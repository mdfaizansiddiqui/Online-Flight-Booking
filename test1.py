try:
    from test import application
    import unittest
    import os
    from flask import Flask,send_from_directory
    from nose.tools import assert_is_not_none
    from flask import request

except Exception as e:
    print("some modules are missing{}".format(e))
    
    
class FlaskTest(unittest.TestCase):
    
    def test_load_ticket(self):
        tester = application.test_client()
        response = tester.get("/load_tickets")
        statuscode=response.status_code 
        self.assertEqual(statuscode,200)
        
        
        
    def test_load_images(self):
        tester = application.test_client()
        response = tester.get("/load_images1")
        statuscode=response.status_code 
        self.assertEqual(statuscode,200)

        
        
    def test_get_css(self):
        tester = application.test_client()
        response = tester.get("/get_css",content_type='application/json',follow_redirects=True)
#        path = os.getcwd()+'/static'
#        #return send_from_directory(path,'style.css')
#        self.assertEqual(response,send_from_directory(path,'style.css'))
        self.assertEqual(response.status_code,200)
    
    
    
    def test_get_filters(self):
        tester = application.test_client()
        response = tester.get("/get_filters3",content_type='application/json',follow_redirects=True)
#        path = os.getcwd()+'/static'
#        #return send_from_directory(path,'style.css')
#        self.assertEqual(response,send_from_directory(path,'style.css'))
        self.assertEqual(response.status_code,200)
    
    
    
    def test_check_validity(self):
        
        tester = application.test_client()
        resp = tester.post('/check_validity')
#        self.assertIs(response,'application/json')
        self.assertEqual(resp.status_code,200)
    
    
    
    def test_load_box(self):
        tester = application.test_client()
        response = tester.post("/load_box")
        statuscode=response.status_code 
        self.assertEqual(statuscode,200)
        
        
        
    def test_make_booking(self):
        tester = application.test_client()
        response = tester.post("/make_booking")
        self.assertEqual(response.status_code,500)
        
        
        
    def test_load_more_tickets(self):
        
        tester = application.test_client()
        response = tester.get("/load_more_tickets")
        self.assertEqual(response.status_code,200)
        
        
    def test_get_xml(self): 
        
        tester = application.test_client()
        response = tester.get("/load_more_tickets")
        self.assertEqual(response.status_code,200)
        
    @unittest.expectedFailure
    def test_subscribe_rss_feed(self):
        tester = application.test_client()
        response = tester.post("/subscribe")
        self.assertEqual(response.status_code,200)
        
    def test_get_rss(self):
        
        tester = application.test_client()
        response = tester.get("/get_rss")
        self.assertEqual(response.status_code,200)
        
        
    
if __name__ ==  "__main__":
    unittest.main()