
Github link :: https://github.com/shripadbharnuke/Result-Management.git

Database : restapiserver.sql find in "db" folder

API List
=================
User Login(POST):
URL: http://localhost/rest-api/api/login
BODY:
email:admin@admin.com
password:admin
device_id :123456789012345

=================
User Logout(POST): 
URL: http://localhost/rest-api/api/logout
BODY:
API-ACCESS-TOKEN:1F33C098-5141-1AEB-9CCE-1A0404567A68
DEVICE-ID:123456789012345
device_id:123456789012345

=================
User Registration(POST): 
URL: http://localhost/rest-api/api/register
HEADERS:
API-ACCESS-TOKEN:720047DA-C7BA-DFF0-159E-D90C39E044E9
DEVICE-ID:12345678901234
----------------
BODY:
email:shripad@admin.com
password:password
device_id:123456789012345
username:shripad
name:Shripad
confirm_password:password
code:FCV4RS

=================

Student List(GET): 
URL: http://localhost/rest-api/api/student/list
HEADERS:
API-ACCESS-TOKEN:720047DA-C7BA-DFF0-159E-D90C39E044E9
DEVICE-ID:12345678901234

=========================

ADD STUDENT(POST): 
URL: http://localhost/rest-api/api/student/addstudent
HEADERS:
API-ACCESS-TOKEN:720047DA-C7BA-DFF0-159E-D90C39E044E9
DEVICE-ID:12345678901234
----------------
BODY:
name:student 2
age:14
mathmarks:55
sciencemarks:77
englishmarks:88

=========================

EDIT STUDENT(POST): 
URL: http://localhost/rest-api/api/student/editstudent
HEADERS:
API-ACCESS-TOKEN:720047DA-C7BA-DFF0-159E-D90C39E044E9
DEVICE-ID:12345678901234
----------------
BODY:
name:student 3
age:12
mathmarks:88
sciencemarks:66
englishmarks:67
student_id:10


