import os, sys
sys.path.append("/home1/susy79/public_html/djangotest");

### EDIT LINE ABOVE TO YOUR SITE ###

os.environ['DJANGO_SETTINGS_MODULE'] = 'settings'
os.environ['PYTHON_EGG_CACHE'] = '/home1/susy79/.python_egg_cache'

### YOU NEED TO CREATE THE DIRECTORY ABOVE ###

import django.core.handlers.wsgi
_application = django.core.handlers.wsgi.WSGIHandler()
def application(environ, start_response):
    environ['PATH_INFO'] = environ['SCRIPT_NAME'] + environ['PATH_INFO']
    return _application(environ, start_response)
