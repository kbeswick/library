from django.contrib import admin
from models import AdminDocument

class AdminDocumentAdmin(admin.ModelAdmin):
	search_fields = ['zone_title', 'zone_author']
	list_filter = ['submit_date']
	date_hierarchy = 'submit_date'

admin.site.register(AdminDocument, AdminDocumentAdmin)
