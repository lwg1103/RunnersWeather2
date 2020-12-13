# 0.12.0
fb token auth endpoint

# 0.11.0
piechart with requests by decision

# 0.10.0
histogram with requests by time

# 0.9
new api endpoint /api/stats/api-request/group/time
fixed CORS problem

# 0.8
divided front and backend application
gather api stats in elasticsearch

# 0.7 
initial map and location provider (working on desktop)

minor changes:
added current time to api response
performance improvements - cache chain added

bugfixes:
crash if airly provider was not available in the area
averages failes if airly provider was missing

# 0.6 
decision maker

# 0.5 
average conditions calculator

# 0.4 
airly integration

# 0.3 
open weather integration

# 0.2 
simple recommendation screen

# 0.1 
initial version

# info

### mysql & elastic
docker-compose -f docker-compose.yaml up -d

### deployment
ansible-playbook -i etc/hosts etc/deploy/deploy.yml

### front repository
https://github.com/lwg1103/RunnersWeather2-front