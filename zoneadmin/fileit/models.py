from django.db import models
from django.utils.translation import ugettext as _ 

# Create your models here.

class Submitter(models.Model):
    submitter_email = models.EmailField()
    submitter_name = models.CharField(max_length=75)

    def __unicode__(self):
        return self.submitter_name


class DocType(models.Model):
    document_type = models.CharField(max_length=75)

    def __unicode__(self):
        return self.document_type


class AdminDocument(models.Model):
    zone_title = models.CharField(max_length=200)
    zone_author = models.CharField(max_length=75)
    document_file = models.FileField(upload_to='zone/%Y/%m/%d')
    document_type = models.ForeignKey(DocType, verbose_name=_("type of permission"))
    submitter = models.ForeignKey(Submitter)
    submit_date = models.DateTimeField(auto_now=True)

    def __unicode__(self):
        return self.zone_title + str(self.submit_date)
