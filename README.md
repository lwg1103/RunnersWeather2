# 0.8.0
morning notification

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

# deployment
ansible-playbook -i etc/hosts etc/deploy/deploy.yml
