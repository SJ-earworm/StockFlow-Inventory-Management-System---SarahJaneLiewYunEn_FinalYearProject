import pymysql
import pandas as pd
from prophet import Prophet
import numpy as np
from scipy import stats
import heapq
import sys
import logging
import json

# connecting to phpmyadmin database
con = pymysql.connect(
    host="localhost",
    user="root",
    password="",
    database="stockflowFINALYEARPROJECT_db"
)

# setting db operation variable
cursor = con.cursor()

# extracting userID & user-set forecast period from passed arguments
userID = sys.argv[1]
forecastperiod = sys.argv[2]

# temporary hardcode
# userID = 1
# forecastperiod = 100

# declaring accessible variables
result = "placeholder"

# retrieving sales records
# '\' for code line continuation
try:
    query = "SELECT \
            s.timestamp, \
            sil.productID, \
            p.prod_name, \
            p.SKU, \
            sil.quantity_bought \
        FROM \
            Sales s \
        JOIN \
            Sales_Item_Link sil ON s.salesID = sil.salesID \
        JOIN \
            Product p ON sil.productID = p.productID \
        WHERE \
            p.storeID IN ( \
                SELECT storeID \
                FROM User \
                WHERE userID = %s \
            )"  # %s is a string placeholder, equivalent to "s" in php prepared statements

    # execute query, with userID as the parameter for the %s placeholder
    cursor.execute(query, (userID,))

    # fetch query result
    result = cursor.fetchall()

except pymysql.MySQLError as e:
    # catching errors if they occur
    print(f"MySQLError: {e}")

finally:
    # close cursor connection for resource management & security
    cursor.close()

    # close database connection
    con.close()




# forecasting with fb prophet
if len(result) > 0:
    # test
    logging.debug("Rows retrieved: " + str(len(result)))

    # loading the raw data into the pandas dataframe (arranging into a 2D array of rows & columns)
    dataframe = pd.DataFrame(result, columns=['ds', 'Product ID', 'Product Name', 'SKU', 'y'])  # ds = timestamp, y = quantity_bought. \
                                                                                                # Prophet looks for ds and y columns as the columns to process. so you can't name them anything else.
    # PUTTING EACH PRODUCT ID FOUND IN THE DATAFRAME (TABLE) INTO THE FORECASTING SEQUENCE
    allProductIDsList = dataframe['Product ID'].unique()  # placing one of each (non duplicate) productID into a list
    
    # test
    # print(dataframe)
    
    try:
        # dictionary (key-value pair 'array') for holding the accumulated forecast value for comparison
        total_quantity_forecast = {}

        # looping thru each productID found in the list to perform individual product forecasting
        for eachproductID in allProductIDsList:
            # putting the rows of the current productID into a new dataframe
            epDataframe = dataframe[dataframe['Product ID'] == eachproductID]

            # stop current iteration & move to the next productID if not enough rows to process/dataframe is empty
            # reason: Prophet will not work properly if there are less than 2 rows of data to process
            if len(epDataframe) < 2 or epDataframe[['ds', 'y']].isnull().values.any():
                logging.debug("Too little rows/no data in epDataframe, moving to the next product")
                print("Too little rows/no data in epDataframe, moving to the next product")
                continue
            # test
            # print("printing epDataframe")
            # print(epDataframe)


            # fb prophet sequence
            # setting the model
            m = Prophet(interval_width=0.95, daily_seasonality=True)
            # training the model
            model = m.fit(epDataframe)
            # notes: 
            # m = Prophet()   <-- creating new instance of Prophet model
            # interval_width=0.95   <-- setting a higher confidence interval to have a conservative prediction (more balanced, not too overly optimistic / pessimistic forecasts)   *default is 0.8
            # daily seasonality=True    <-- considering daily seasonality (sales) fluctuations
            # m.fit(dataframe)  <-- fitting the Prophet model into the dataframe to feed on the data and learn the patterns & trends in the data


            # producing the forecast
            # periods to forecast forward according to user choice
            future = m.make_future_dataframe(periods=forecastperiod, freq='D')
            forecast = m.predict(future)

            # internal testing
            # print(forecast.head())
            # print(m.plot_components(forecast))  # plot line graph

            # PROBLEM HERE, for loop not being touched

            # debugging
            # print("going into for accumulation loop")
            # iterating thru the forecast rows
            for index, row in forecast.iterrows():
                # adding up the forecasted yhat (quantity_bought)
                if eachproductID in total_quantity_forecast:
                    total_quantity_forecast[eachproductID] += row['yhat']
                    # print(f"current EXISTING total forecast quant: {total_quantity_forecast[eachproductID]}")
                else:
                    total_quantity_forecast[eachproductID] = row['yhat']
                    # print(f"new accumulative forecast quant: {total_quantity_forecast[eachproductID]}")
        

        # finding which product has the most forecasted sales during the period
        # converting total_quantity_forecast dictionary into a list (so taht we can use np.array)
        # yhat_values = np.array(list(total_quantity_forecast.values()))
        
        # finding mode quantity sold
        # modequantity = stats.mode(yhat_values)

        # identifying which product the mode value belongs to
        # for 

        # test
        # print ("AFTER ACCUMULATION SEQUENCE")


        # finding the top 5 forecasted product quantities
        top_5_sales = heapq.nlargest(5, total_quantity_forecast.items(), key=lambda item: item[1])
        # test
        logging.debug(top_5_sales)

        # sending data back to php for displaying into the interface
        print(json.dumps(top_5_sales))  # sending arrays requires passing json output via json.dumps()


    except ValueError as e:
        print(f"Error: {e}")
    except Exception as e:
        print(f"Error: {e}")
    
else:
    print("Did not retrieve any results.")