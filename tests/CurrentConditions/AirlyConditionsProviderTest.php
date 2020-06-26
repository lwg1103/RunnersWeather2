<?php

namespace App\Tests\CurrentConditions;

use App\CurrentConditions\AirlyConditionsProvider;
use App\Conditions\WeatherConditions;

class AirlyConditionsProviderTest extends ConditionsProviderBase
{
    const APIResponse = "{\"current\":{\"fromDateTime\":\"2019-12-23T20:32:10.745Z\",\"tillDateTime\":\"2019-12-23T21:32:10.745Z\",\"values\":[{\"name\":\"PM1\",\"value\":9.96},{\"name\":\"PM25\",\"value\":15.85},{\"name\":\"PM10\",\"value\":21.83},{\"name\":\"PRESSURE\",\"value\":1008.58},{\"name\":\"HUMIDITY\",\"value\":87.03},{\"name\":\"TEMPERATURE\",\"value\":5.07}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":26.42,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"You can go out and enjoy nature without worries.\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":63.41},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":43.66}]},\"history\":[{\"fromDateTime\":\"2019-12-22T21:00:00.000Z\",\"tillDateTime\":\"2019-12-22T22:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":25.53},{\"name\":\"PM25\",\"value\":39.36},{\"name\":\"PM10\",\"value\":61.05},{\"name\":\"PRESSURE\",\"value\":993.43},{\"name\":\"HUMIDITY\",\"value\":89.85},{\"name\":\"TEMPERATURE\",\"value\":3.06}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":59.36,\"level\":\"MEDIUM\",\"description\":\"Well... It's been better.\",\"advice\":\"The air is slightly polluted.\",\"color\":\"#EFBB0F\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":157.43},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":122.09}]},{\"fromDateTime\":\"2019-12-22T22:00:00.000Z\",\"tillDateTime\":\"2019-12-22T23:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":27.95},{\"name\":\"PM25\",\"value\":42.41},{\"name\":\"PM10\",\"value\":63.55},{\"name\":\"PRESSURE\",\"value\":993.69},{\"name\":\"HUMIDITY\",\"value\":90.68},{\"name\":\"TEMPERATURE\",\"value\":2.98}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":62.41,\"level\":\"MEDIUM\",\"description\":\"Well... It's been better.\",\"advice\":\"Sadly, the air is not quite as clean as it looks today.\",\"color\":\"#EFBB0F\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":169.63},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":127.1}]},{\"fromDateTime\":\"2019-12-22T23:00:00.000Z\",\"tillDateTime\":\"2019-12-23T00:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":33.45},{\"name\":\"PM25\",\"value\":51.13},{\"name\":\"PM10\",\"value\":73.09},{\"name\":\"PRESSURE\",\"value\":993.83},{\"name\":\"HUMIDITY\",\"value\":91.0},{\"name\":\"TEMPERATURE\",\"value\":2.97}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":71.13,\"level\":\"MEDIUM\",\"description\":\"Well... It's been better.\",\"advice\":\"The air doesn't encourage walking today.\",\"color\":\"#EFBB0F\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":204.53},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":146.17}]},{\"fromDateTime\":\"2019-12-23T00:00:00.000Z\",\"tillDateTime\":\"2019-12-23T01:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":38.67},{\"name\":\"PM25\",\"value\":59.33},{\"name\":\"PM10\",\"value\":83.57},{\"name\":\"PRESSURE\",\"value\":994.1},{\"name\":\"HUMIDITY\",\"value\":91.0},{\"name\":\"TEMPERATURE\",\"value\":2.85}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":76.97,\"level\":\"HIGH\",\"description\":\"Poor air quality!\",\"advice\":\"Avoid being outside if possible.\",\"color\":\"#EF7120\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":237.3},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":167.14}]},{\"fromDateTime\":\"2019-12-23T01:00:00.000Z\",\"tillDateTime\":\"2019-12-23T02:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":38.27},{\"name\":\"PM25\",\"value\":59.79},{\"name\":\"PM10\",\"value\":84.35},{\"name\":\"PRESSURE\",\"value\":994.44},{\"name\":\"HUMIDITY\",\"value\":91.53},{\"name\":\"TEMPERATURE\",\"value\":2.8}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":77.18,\"level\":\"HIGH\",\"description\":\"Poor air quality!\",\"advice\":\"Define the air quality in one word? NOT GOOD. Ok, two words ;)\",\"color\":\"#EF7120\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":239.14},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":168.7}]},{\"fromDateTime\":\"2019-12-23T02:00:00.000Z\",\"tillDateTime\":\"2019-12-23T03:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":31.46},{\"name\":\"PM25\",\"value\":52.51},{\"name\":\"PM10\",\"value\":75.38},{\"name\":\"PRESSURE\",\"value\":994.98},{\"name\":\"HUMIDITY\",\"value\":91.75},{\"name\":\"TEMPERATURE\",\"value\":2.9}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":72.51,\"level\":\"MEDIUM\",\"description\":\"Well... It's been better.\",\"advice\":\"Things were good once... Let's hope it doesn't get worse!\",\"color\":\"#EFBB0F\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":210.04},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":150.75}]},{\"fromDateTime\":\"2019-12-23T03:00:00.000Z\",\"tillDateTime\":\"2019-12-23T04:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":34.43},{\"name\":\"PM25\",\"value\":56.3},{\"name\":\"PM10\",\"value\":79.83},{\"name\":\"PRESSURE\",\"value\":995.76},{\"name\":\"HUMIDITY\",\"value\":92.29},{\"name\":\"TEMPERATURE\",\"value\":2.91}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":75.59,\"level\":\"HIGH\",\"description\":\"Poor air quality!\",\"advice\":\"Leave the car - trains, trams and buses are cool too!\",\"color\":\"#EF7120\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":225.19},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":159.66}]},{\"fromDateTime\":\"2019-12-23T04:00:00.000Z\",\"tillDateTime\":\"2019-12-23T05:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":38.43},{\"name\":\"PM25\",\"value\":61.32},{\"name\":\"PM10\",\"value\":86.81},{\"name\":\"PRESSURE\",\"value\":996.24},{\"name\":\"HUMIDITY\",\"value\":92.5},{\"name\":\"TEMPERATURE\",\"value\":2.93}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":77.87,\"level\":\"HIGH\",\"description\":\"Poor air quality!\",\"advice\":\"It's not good, oh no!\",\"color\":\"#EF7120\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":245.27},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":173.62}]},{\"fromDateTime\":\"2019-12-23T05:00:00.000Z\",\"tillDateTime\":\"2019-12-23T06:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":29.3},{\"name\":\"PM25\",\"value\":48.84},{\"name\":\"PM10\",\"value\":73.16},{\"name\":\"PRESSURE\",\"value\":996.87},{\"name\":\"HUMIDITY\",\"value\":92.5},{\"name\":\"TEMPERATURE\",\"value\":3.09}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":68.84,\"level\":\"MEDIUM\",\"description\":\"Well... It's been better.\",\"advice\":\"If you can, stay home.\",\"color\":\"#EFBB0F\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":195.36},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":146.31}]},{\"fromDateTime\":\"2019-12-23T06:00:00.000Z\",\"tillDateTime\":\"2019-12-23T07:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":25.23},{\"name\":\"PM25\",\"value\":42.8},{\"name\":\"PM10\",\"value\":64.63},{\"name\":\"PRESSURE\",\"value\":997.69},{\"name\":\"HUMIDITY\",\"value\":92.92},{\"name\":\"TEMPERATURE\",\"value\":3.31}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":62.8,\"level\":\"MEDIUM\",\"description\":\"Well... It's been better.\",\"advice\":\"This isn't the best day for out-of-home activities.\",\"color\":\"#EFBB0F\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":171.21},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":129.26}]},{\"fromDateTime\":\"2019-12-23T07:00:00.000Z\",\"tillDateTime\":\"2019-12-23T08:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":24.66},{\"name\":\"PM25\",\"value\":41.18},{\"name\":\"PM10\",\"value\":62.93},{\"name\":\"PRESSURE\",\"value\":998.6},{\"name\":\"HUMIDITY\",\"value\":93.67},{\"name\":\"TEMPERATURE\",\"value\":3.54}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":61.18,\"level\":\"MEDIUM\",\"description\":\"Well... It's been better.\",\"advice\":\"Neither good nor bad. Think before leaving the house.\",\"color\":\"#EFBB0F\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":164.7},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":125.86}]},{\"fromDateTime\":\"2019-12-23T08:00:00.000Z\",\"tillDateTime\":\"2019-12-23T09:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":22.68},{\"name\":\"PM25\",\"value\":37.86},{\"name\":\"PM10\",\"value\":60.34},{\"name\":\"PRESSURE\",\"value\":999.34},{\"name\":\"HUMIDITY\",\"value\":93.99},{\"name\":\"TEMPERATURE\",\"value\":3.6}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":57.86,\"level\":\"MEDIUM\",\"description\":\"Well... It's been better.\",\"advice\":\"This isn't the best day for out-of-home activities.\",\"color\":\"#EFBB0F\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":151.42},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":120.69}]},{\"fromDateTime\":\"2019-12-23T09:00:00.000Z\",\"tillDateTime\":\"2019-12-23T10:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":19.46},{\"name\":\"PM25\",\"value\":31.45},{\"name\":\"PM10\",\"value\":50.18},{\"name\":\"PRESSURE\",\"value\":999.89},{\"name\":\"HUMIDITY\",\"value\":93.62},{\"name\":\"TEMPERATURE\",\"value\":4.13}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":51.45,\"level\":\"MEDIUM\",\"description\":\"Well... It's been better.\",\"advice\":\"If you can, stay home.\",\"color\":\"#EFBB0F\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":125.78},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":100.35}]},{\"fromDateTime\":\"2019-12-23T10:00:00.000Z\",\"tillDateTime\":\"2019-12-23T11:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":13.6},{\"name\":\"PM25\",\"value\":21.51},{\"name\":\"PM10\",\"value\":31.42},{\"name\":\"PRESSURE\",\"value\":1000.22},{\"name\":\"HUMIDITY\",\"value\":92.42},{\"name\":\"TEMPERATURE\",\"value\":4.51}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":35.86,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"Do you smell it? That's the smell of clean air. :)\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":86.06},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":62.85}]},{\"fromDateTime\":\"2019-12-23T11:00:00.000Z\",\"tillDateTime\":\"2019-12-23T12:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":9.19},{\"name\":\"PM25\",\"value\":13.96},{\"name\":\"PM10\",\"value\":18.73},{\"name\":\"PRESSURE\",\"value\":1000.57},{\"name\":\"HUMIDITY\",\"value\":90.96},{\"name\":\"TEMPERATURE\",\"value\":5.03}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":23.27,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Breathe to fill your lungs!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":55.84},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":37.47}]},{\"fromDateTime\":\"2019-12-23T12:00:00.000Z\",\"tillDateTime\":\"2019-12-23T13:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":7.33},{\"name\":\"PM25\",\"value\":10.99},{\"name\":\"PM10\",\"value\":14.66},{\"name\":\"PRESSURE\",\"value\":1001.16},{\"name\":\"HUMIDITY\",\"value\":88.38},{\"name\":\"TEMPERATURE\",\"value\":5.69}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":18.31,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Green equals clean!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":43.94},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":29.33}]},{\"fromDateTime\":\"2019-12-23T13:00:00.000Z\",\"tillDateTime\":\"2019-12-23T14:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":6.72},{\"name\":\"PM25\",\"value\":10.17},{\"name\":\"PM10\",\"value\":13.76},{\"name\":\"PRESSURE\",\"value\":1002.08},{\"name\":\"HUMIDITY\",\"value\":87.02},{\"name\":\"TEMPERATURE\",\"value\":5.84}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":16.95,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Perfect air for exercising! Go for it!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":40.69},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":27.52}]},{\"fromDateTime\":\"2019-12-23T14:00:00.000Z\",\"tillDateTime\":\"2019-12-23T15:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":6.41},{\"name\":\"PM25\",\"value\":9.54},{\"name\":\"PM10\",\"value\":12.76},{\"name\":\"PRESSURE\",\"value\":1003.04},{\"name\":\"HUMIDITY\",\"value\":86.41},{\"name\":\"TEMPERATURE\",\"value\":5.72}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":15.9,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"It couldn't be better ;)\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":38.16},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":25.51}]},{\"fromDateTime\":\"2019-12-23T15:00:00.000Z\",\"tillDateTime\":\"2019-12-23T16:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":8.19},{\"name\":\"PM25\",\"value\":11.71},{\"name\":\"PM10\",\"value\":15.75},{\"name\":\"PRESSURE\",\"value\":1004.26},{\"name\":\"HUMIDITY\",\"value\":86.79},{\"name\":\"TEMPERATURE\",\"value\":5.42}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":19.52,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"The air is grand today. ;)\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":46.85},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":31.51}]},{\"fromDateTime\":\"2019-12-23T16:00:00.000Z\",\"tillDateTime\":\"2019-12-23T17:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":11.3},{\"name\":\"PM25\",\"value\":18.1},{\"name\":\"PM10\",\"value\":24.83},{\"name\":\"PRESSURE\",\"value\":1005.3},{\"name\":\"HUMIDITY\",\"value\":88.14},{\"name\":\"TEMPERATURE\",\"value\":5.37}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":30.17,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"You can go outside without any worries.\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":72.41},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":49.65}]},{\"fromDateTime\":\"2019-12-23T17:00:00.000Z\",\"tillDateTime\":\"2019-12-23T18:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":13.07},{\"name\":\"PM25\",\"value\":21.56},{\"name\":\"PM10\",\"value\":31.39},{\"name\":\"PRESSURE\",\"value\":1006.22},{\"name\":\"HUMIDITY\",\"value\":88.23},{\"name\":\"TEMPERATURE\",\"value\":5.45}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":35.94,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"You can go outside without any worries.\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":86.26},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":62.78}]},{\"fromDateTime\":\"2019-12-23T18:00:00.000Z\",\"tillDateTime\":\"2019-12-23T19:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":10.72},{\"name\":\"PM25\",\"value\":17.5},{\"name\":\"PM10\",\"value\":24.21},{\"name\":\"PRESSURE\",\"value\":1007.03},{\"name\":\"HUMIDITY\",\"value\":87.21},{\"name\":\"TEMPERATURE\",\"value\":5.33}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":29.16,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"It's a good time to use those rollerskates today!\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":70.0},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":48.43}]},{\"fromDateTime\":\"2019-12-23T19:00:00.000Z\",\"tillDateTime\":\"2019-12-23T20:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":9.52},{\"name\":\"PM25\",\"value\":15.17},{\"name\":\"PM10\",\"value\":20.79},{\"name\":\"PRESSURE\",\"value\":1007.62},{\"name\":\"HUMIDITY\",\"value\":86.31},{\"name\":\"TEMPERATURE\",\"value\":5.22}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":25.28,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"Yes, yes - it's true. The air quality is good today!\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":60.67},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":41.58}]},{\"fromDateTime\":\"2019-12-23T20:00:00.000Z\",\"tillDateTime\":\"2019-12-23T21:00:00.000Z\",\"values\":[{\"name\":\"PM1\",\"value\":9.5},{\"name\":\"PM25\",\"value\":15.12},{\"name\":\"PM10\",\"value\":20.81},{\"name\":\"PRESSURE\",\"value\":1008.28},{\"name\":\"HUMIDITY\",\"value\":86.51},{\"name\":\"TEMPERATURE\",\"value\":5.1}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":25.2,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"It's a good time to use those rollerskates today!\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":60.47},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":41.62}]}],\"forecast\":[{\"fromDateTime\":\"2019-12-23T21:00:00.000Z\",\"tillDateTime\":\"2019-12-23T22:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":14.54},{\"name\":\"PM10\",\"value\":22.09}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":24.24,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Zero dust - zero worries!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":58.17},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":44.18}]},{\"fromDateTime\":\"2019-12-23T22:00:00.000Z\",\"tillDateTime\":\"2019-12-23T23:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":15.13},{\"name\":\"PM10\",\"value\":23.03}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":25.22,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"You can go out and enjoy nature without worries.\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":60.53},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":46.05}]},{\"fromDateTime\":\"2019-12-23T23:00:00.000Z\",\"tillDateTime\":\"2019-12-24T00:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":15.79},{\"name\":\"PM10\",\"value\":24.05}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":26.32,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"It's a good time to use those rollerskates today!\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":63.17},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":48.1}]},{\"fromDateTime\":\"2019-12-24T00:00:00.000Z\",\"tillDateTime\":\"2019-12-24T01:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":16.17},{\"name\":\"PM10\",\"value\":24.96}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":26.95,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"A perfect day for outdoor sports!\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":64.68},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":49.92}]},{\"fromDateTime\":\"2019-12-24T01:00:00.000Z\",\"tillDateTime\":\"2019-12-24T02:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":16.08},{\"name\":\"PM10\",\"value\":25.05}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":26.8,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"Enjoy the clean air.\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":64.31},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":50.09}]},{\"fromDateTime\":\"2019-12-24T02:00:00.000Z\",\"tillDateTime\":\"2019-12-24T03:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":15.91},{\"name\":\"PM10\",\"value\":24.9}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":26.51,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"You can go outside without any worries.\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":63.63},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":49.81}]},{\"fromDateTime\":\"2019-12-24T03:00:00.000Z\",\"tillDateTime\":\"2019-12-24T04:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":15.69},{\"name\":\"PM10\",\"value\":24.82}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":26.15,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"A perfect day for outdoor sports!\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":62.75},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":49.65}]},{\"fromDateTime\":\"2019-12-24T04:00:00.000Z\",\"tillDateTime\":\"2019-12-24T05:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":15.05},{\"name\":\"PM10\",\"value\":24.54}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":25.08,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"The air quality is good today!\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":60.19},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":49.08}]},{\"fromDateTime\":\"2019-12-24T05:00:00.000Z\",\"tillDateTime\":\"2019-12-24T06:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":13.97},{\"name\":\"PM10\",\"value\":23.91}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":23.91,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Breathe to fill your lungs!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":55.9},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":47.82}]},{\"fromDateTime\":\"2019-12-24T06:00:00.000Z\",\"tillDateTime\":\"2019-12-24T07:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":12.83},{\"name\":\"PM10\",\"value\":22.94}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":22.94,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Enjoy life!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":51.32},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":45.87}]},{\"fromDateTime\":\"2019-12-24T07:00:00.000Z\",\"tillDateTime\":\"2019-12-24T08:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":11.62},{\"name\":\"PM10\",\"value\":21.34}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":21.34,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Breathe to fill your lungs!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":46.46},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":42.68}]},{\"fromDateTime\":\"2019-12-24T08:00:00.000Z\",\"tillDateTime\":\"2019-12-24T09:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":10.46},{\"name\":\"PM10\",\"value\":19.63}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":19.63,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Enjoy life!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":41.84},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":39.26}]},{\"fromDateTime\":\"2019-12-24T09:00:00.000Z\",\"tillDateTime\":\"2019-12-24T10:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":9.44},{\"name\":\"PM10\",\"value\":18.1}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":18.1,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"The air is great!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":37.75},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":36.19}]},{\"fromDateTime\":\"2019-12-24T10:00:00.000Z\",\"tillDateTime\":\"2019-12-24T11:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":8.48},{\"name\":\"PM10\",\"value\":16.42}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":16.42,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Feel free to run, walk, dance and let the air outside in today!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":33.91},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":32.84}]},{\"fromDateTime\":\"2019-12-24T11:00:00.000Z\",\"tillDateTime\":\"2019-12-24T12:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":7.89},{\"name\":\"PM10\",\"value\":14.94}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":14.94,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Breathe deeply!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":31.56},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":29.88}]},{\"fromDateTime\":\"2019-12-24T12:00:00.000Z\",\"tillDateTime\":\"2019-12-24T13:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":7.85},{\"name\":\"PM10\",\"value\":14.53}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":14.53,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Breathe deeply!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":31.41},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":29.07}]},{\"fromDateTime\":\"2019-12-24T13:00:00.000Z\",\"tillDateTime\":\"2019-12-24T14:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":8.7},{\"name\":\"PM10\",\"value\":15.6}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":15.6,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Green equals clean!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":34.79},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":31.2}]},{\"fromDateTime\":\"2019-12-24T14:00:00.000Z\",\"tillDateTime\":\"2019-12-24T15:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":10.69},{\"name\":\"PM10\",\"value\":18.14}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":18.14,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Feel free to run, walk, dance and let the air outside in today!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":42.74},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":36.27}]},{\"fromDateTime\":\"2019-12-24T15:00:00.000Z\",\"tillDateTime\":\"2019-12-24T16:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":13.75},{\"name\":\"PM10\",\"value\":21.94}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":22.91,\"level\":\"VERY_LOW\",\"description\":\"Great air here today!\",\"advice\":\"Dear me, how wonderful!\",\"color\":\"#6BC926\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":54.98},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":43.88}]},{\"fromDateTime\":\"2019-12-24T16:00:00.000Z\",\"tillDateTime\":\"2019-12-24T17:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":17.48},{\"name\":\"PM10\",\"value\":26.73}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":29.14,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"Yes, yes - it's true. The air quality is good today!\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":69.93},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":53.46}]},{\"fromDateTime\":\"2019-12-24T17:00:00.000Z\",\"tillDateTime\":\"2019-12-24T18:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":21.14},{\"name\":\"PM10\",\"value\":31.41}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":35.24,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"The air is nice and clean today!\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":84.57},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":62.82}]},{\"fromDateTime\":\"2019-12-24T18:00:00.000Z\",\"tillDateTime\":\"2019-12-24T19:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":23.99},{\"name\":\"PM10\",\"value\":34.92}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":39.98,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"Do you want to see what's outside? The air is nice today!\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":95.95},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":69.85}]},{\"fromDateTime\":\"2019-12-24T19:00:00.000Z\",\"tillDateTime\":\"2019-12-24T20:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":25.93},{\"name\":\"PM10\",\"value\":37.01}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":43.22,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"Do you smell it? That's the smell of clean air. :)\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":103.74},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":74.01}]},{\"fromDateTime\":\"2019-12-24T20:00:00.000Z\",\"tillDateTime\":\"2019-12-24T21:00:00.000Z\",\"values\":[{\"name\":\"PM25\",\"value\":26.99},{\"name\":\"PM10\",\"value\":38.0}],\"indexes\":[{\"name\":\"AIRLY_CAQI\",\"value\":44.99,\"level\":\"LOW\",\"description\":\"Air is quite good.\",\"advice\":\"A perfect day for outdoor sports!\",\"color\":\"#D1CF1E\"}],\"standards\":[{\"name\":\"WHO\",\"pollutant\":\"PM25\",\"limit\":25.0,\"percent\":107.98},{\"name\":\"WHO\",\"pollutant\":\"PM10\",\"limit\":50.0,\"percent\":76.0}]}]}";

    protected function setUp()
    {
        parent::setUp();

        $this->AirlyConditionsProvider = new AirlyConditionsProvider;
    }

    protected function thenResultHasValues()
    {
        $emptyWeatherConditions = new WeatherConditions;

        $this->assertNotEquals($emptyWeatherConditions->pm10, $this->result->pm10);
        $this->assertNotEquals($emptyWeatherConditions->pm25, $this->result->pm25);
        $this->assertNotEquals($emptyWeatherConditions->temperature, $this->result->temperature);
        $this->assertNotEquals($emptyWeatherConditions->humidity, $this->result->humidity);
    }

    protected function thenResultHasResponseValues()
    {
        $this->assertEquals(21.83, $this->result->pm10);
        $this->assertEquals(15.85, $this->result->pm25);
        $this->assertEquals(5.07, $this->result->temperature);
        $this->assertEquals(87.03, $this->result->humidity);
    }

}
