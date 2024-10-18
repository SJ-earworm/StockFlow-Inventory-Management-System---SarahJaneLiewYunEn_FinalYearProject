import pymysql
import pandas as pd
from prophet import Prophet
import sys

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
# userID = sys.argv[1]
# forecastperiod = sys.argv[2]

# temporary hardcode
userID = 1
forecastperiod = 100

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
    print("Rows retrieved: " + str(len(result)))

    # loading the raw data into the pandas dataframe (arranging into a 2D array of rows & columns)
    dataframe = pd.DataFrame(result, columns=['ds', 'Product ID', 'Product Name', 'SKU', 'y'])  # ds = timestamp, y = quantity_bought. \
                                                                                                # Prophet looks for ds and y columns as the columns to process. so you can't name them anything else.
    # PUTTING EACH PRODUCT ID FOUND IN THE DATAFRAME (TABLE) INTO THE FORECASTING SEQUENCE
    allProductIDsList = dataframe['Product ID'].unique()  # placing one of each (non duplicate) productID into a list
    
    # test
    # print(dataframe)
    
    try:
        # looping thru each productID found in the list to perform individual product forecasting
        for eachproduct in allProductIDsList:
            # putting the rows of the current productID into a new dataframe
            epDataframe = dataframe[dataframe['Product ID'] == eachproduct]
            

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
            print(forecast.head())
            # print(m.plot_components(forecast))  # plot line graph
            
            # test output
            # print("finished python sequence")

            # sending data back to php for displaying into the interface

    except ValueError as e:
        print(f"Error: {e}")
    except Exception as e:
        print(f"Error: {e}")
    
else:
    print("Did not retrieve any results.")