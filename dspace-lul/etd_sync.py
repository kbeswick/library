#!/usr/bin/python

# etd_sync
#
# A script which searches a DSpace database for any items under
# collections named "Masters Theses", "Doctoral Theses", and "Undergraduate
# Theses", and adds them to a top level Electronic Theses community

import psycopg2

# the id's of the top level masters/doctoral/undergrad theses collections
UNDERGRAD_ID = '103'
MASTERS_ID = '104'
DOCTORAL_ID = '105'

# database settings
DB = {}
DB['USER'] = "my_db_user"
DB['PASSWORD'] = "my_db_password"
DB['NAME'] = "my_db_name"


masters = {'collection': 'Masters Theses', 'id': MASTERS_ID}
undergrad = {'collection': 'Undergraduate Theses', 'id': UNDERGRAD_ID}
doctoral = {'collection': 'Doctoral Theses', 'id': DOCTORAL_ID}

def get_items(type):
  conn = psycopg2.connect("dbname=%s user=%s" % (DB['NAME'], DB['USER']) )
  cur = conn.cursor()
  #find all items that aren't in the top level collection yet
  items_query = """select item_id from item where owning_collection in
                     (select collection_id from collection
                        where name = %s and collection_id != %s) and item_id
                        not in (select item_id from collection2item where
                        collection_id = %s);"""
  cur.execute(items_query, (type['collection'], type['id'], type['id'],))
  items = cur.fetchall()
  return items

def sync_items(items, type):
  #our items should be in the form of a list of tuples
  if not items:
    return None

  conn = psycopg2.connect("dbname=%s user=%s" % (DB['NAME'], DB['USER']))
  cur = conn.cursor()

  for i in items:
    item_insert = """insert into collection2item (id, collection_id, item_id)
                       values (nextval('collection2item_seq'), %s, %s);"""
    cur.execute(item_insert, (type['id'], i[0],))
  conn.commit()


# Run for undergrad, masters, and doctoral

undergrad_items = get_items(undergrad)
masters_items = get_items(masters)
doctorate_items = get_items(doctoral)

sync_items(undergrad_items, undergrad)
sync_items(masters_items, masters)
sync_items(doctorate_items, doctoral)
