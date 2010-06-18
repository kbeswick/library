from django.conf.urls.defaults import *

from django.contrib import admin
admin.autodiscover()

urlpatterns = patterns('',
    # Example:
    # (r'^zoneadmin/', include('zoneadmin.foo.urls')),

    # Uncomment this for admin:
    (r'^zoneadmin/', include(admin.site.urls)),

)
