
# Setup
*  Copy/clone the files to the server, e.g. local
*  Add a connection to your own database in the file .env:  ```DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name```
*  Run ``` composer install ```
*  Run Doctrine migrations: ```php bin/console d:m:m ```
* Add dummy data to database
* Use Postman or other application to test api
# Endpoints:

*  /books  
    Show all books in database
   Example:  
   ``` GET http://127.0.0.1:8000/books ```
*  /books/{id}  
    Show specific book with ID = 2
   Example  
   ``` GET http://127.0.0.1:8000/books/2 ```
*  /book/create  
   Example: create book  
   ```POST http://127.0.0.1:8000/book/create ```  
   Json body
 ```
{
    "title": "Harry Potter",
    "publisher": "Zysk",
    "pages": "300"
}
 ```
*  /book/delete/{id}   
   Example:  delete specific book with ID = 3
   ``` DELETE http://127.0.0.1:8000/book/delete/3 ```

  *  /Author/create  
      Example: create author  
      ```POST http://127.0.0.1:8000/author/create ```  
      Json body
 ```
{
    "name": "J.K Rowling",
    "country": "UK"
}
```
*  /author/delete/{id}   
   Example:  delete specific author with ID = 3
   ``` DELETE http://127.0.0.1:8000/author/delete/3 ```

*  /author/{name}  
   Show specific author with name = J.K Rowling
   Example  
   ``` GET http://127.0.0.1:8000/books/J.K Rowling ```
* books/author/{name}  
  Show all author's books with name = J.K Rowling
  Example  
  ``` GET http://127.0.0.1:8000/books/author/J.K Rowling ```