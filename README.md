## Focal-X-Task-4

#Library Management System

## project details

1. **APIS**
    - using JWT Token with auth:api middleware to verify your login.
    - APIs for user operations likes (register - login - logout - show profile - add user with role).
    - CRUD for Books using api resource
    - CRUD for Borrow record using api resource
    - CRUD for Rates using api resource

2. **Validations**
    - The Request form has been used with all the features and services available in it like : authorize ,
      failedAuthorization , rules , attributes , messages.
    - The validation process was done through Form Request to distribute the codes and facilitate the review and
      verification process.
    - Use simple and important expressions and rules in the validation process like: required , exists , unique ,
      numeric ,.......
    - (note) : We did not focus on the(failedAuthorization, failedValidation) cases because they are all handled in the
      handle exception.

3. **Services**
    - Services were used when needed, i.e. when there was complexity in the operations, they were moved from the
      controller to the service.

4. **Response**
    - A middleware called JsonResponse was used to model all responses, whether in valid or exception cases.
    - Middleware is added by default. I make append for this middleware.

5. **EXCEPTIONS**
    - handle Exceptions called CustomHandler is used to capture all types of Exceptions and model their display using a
      status code.

## Additional Notes

- Consider the code fragmentation mechanism
- Display average ratings for each book by building a function into the model that calculates the average and takes
  advantage of the append feature to ensure it displays with each movie.
- For each method there is a comment & document to explain the method operations and define params & returns.
- postman collection attached in laravel project

