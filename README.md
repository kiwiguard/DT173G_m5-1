# PHP rest api

This repo is the REST webservice providing CRUD functionality for 
read stored information about courses.

### Database structure

 >| ID (int, AI, primary key) | name (Varchar(64))| code (Varchar(64)) | progression (Varchar(1)) | syllabus (Varchar(512)) 


## Methods
* **GET** - Fetches course-info stored in databas, in JSON format.
* **POST** - Add a course to the database. Requires information to be provided in JSON-format. As such:

        name: 'Name of the course',
        code: 'DT000G',
        progression: 'A',
        syllabus: 'https://www.syllabuslink.com/'
* **PUT** - Update a course stored in the database. Requires information formatted as seen above.
* **DELETE** - Deletes a course stored in the database. Based on the courses ID.

### Calling the api
Calls are made to: 
            http://localhost/