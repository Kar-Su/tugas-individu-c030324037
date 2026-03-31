# user API Spec

## Create user API

Endpoint : POST /localhost/api/user

Headers :

```json
{
  "Content-Type": "application/json",
}
```

Request Body:
(ROLE DEFAULT Pelanggan)
```json
{
    "username":"test_user",
    "password":"test123",
    "role":"Pelanggan | Admin" //Optional
}
```

Response Body Success:

```json
{
    "status": "success",
    "message": "Successfully created user.",
    "data": {
        "username": "test_user",
        "role": "Pelanggan",
        "id": "3"
    }
}
```

Response Body Error:

```json
{
	"status":  "error",
	"message": "Invalid data format",
}
```

```json
{
	"status":  "error",
	"message": "Failed to save data user",
}
```

```json
{
	"status":  "error",
	"message": "Username already exists",
}
```

## Update user API

Endpoint : PUT /localhost/api/user/(id)

Headers :

```json
{
  "Content-Type": "application/json",
}
```

Request Body:
```json
{
    "password":"gantipw",
    "role":"Admin"
}
```

Response Body Success:

```json
{
    "status": "success",
    "message": "Successfully updated user.",
    "data": {
        "id": 3,
        "username": "test_user",
        "role": "Admin",
        "created_at": "2026-03-31 13:05:03",
        "updated_at": "2026-03-31 13:05:03"
    }
}
```

Response Body Error:

```json
{
	"status":  "error",
	"message": "user not found",
}
```

```json
{
	"status":  "error",
	"message": "Invalid data format",
}
```

## List user API

Endpoint : GET /localhost/api/user

Headers :

```json
{
    "Content-Type": "application/json"
}
```

Response Body Success:

```json
{
    "status": "success",
    "data": [
        {
            "id": 3,
            "username": "test_user",
            "role": "Admin",
            "created_at": "2026-03-31 13:05:03",
            "updated_at": "2026-03-31 13:07:28"
        },
        {
            "id": 2,
            "username": "huda",
            "role": "Pelanggan",
            "created_at": "2026-03-31 12:47:16",
            "updated_at": "2026-03-31 12:47:16"
        },
        {
            "id": 1,
            "username": "helmi",
            "role": "Admin",
            "created_at": "2026-03-31 12:47:16",
            "updated_at": "2026-03-31 12:47:16"
        }
    ]
}
```

Response Body Error:

```json
{
  	"status":  "error",
	"message": "Failed to retrieve data user",
}
```
Endpoint : GET /localhost/api/user/(id)

Headers :

```json
{
    "Content-Type": "application/json"
}
```

Response Body Success:

```json
{
    "status": "success",
    "data": {
        "id": 3,
        "username": "test_user",
        "role": "Admin",
        "created_at": "2026-03-31 13:05:03",
        "updated_at": "2026-03-31 13:07:28"
    }
}
```

Response Body Error:

```json
{
  	"status":  "error",
	"message": "Failed to retrieve data user",
}
```


## Remove user API

Endpoint : DELETE /localhost/api/user/(id)

Headers :

```json
{
  "Content-Type": "application/json"
}
```

Response Body Success:

```json
{
    "message": "Successfully deleted user",
    "status": "success"
}
```

Response Body Error:

```json
{
	"status":  "error",
	"message": "user not found",
}
```
