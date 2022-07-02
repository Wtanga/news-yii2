
1. Create database, user and tables
mysql -u root -p < db.sql

2. Adjust web-server in root directory
cd mokriy_nos/web/
sudo php -S 0.0.0.0:7777

3. Run web browser
google-chrome http://localhost:7777

4. Create testing data in browser (Optional)
Click on "Create Test Data"
