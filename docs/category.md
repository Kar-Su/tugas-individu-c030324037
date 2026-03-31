# category API Spec

## Create category API

Endpoint : POST /localhost/api/category

Headers :

```json
{
  "Content-Type": "application/json",
  "Authorization": "Bearer <JWT_TOKEN>"
}
```

Request Body:

```json
{
    "category_name": "test_post"
}
```

Response Body Success:

```json
{
    "data": {
        "id": 4,
        "category_name": "test_post"
    },
    "message": "Successfully added category",
    "status": "success"
}
```

Response Body Error:

```json
{
	"status":  "error",
	"message": "Failed to retrieve data categories",
}
```

```json
{
	"status":  "error",
	"message": "Invalid data format",
}
```

```json
{
	"status":  "error",
	"message": "Failed to save data category",
}
```

## Update category API

Endpoint : PUT /localhost/api/category/<id>

Headers :

```json
{
  "Content-Type": "application/json",
  "Authorization": "Bearer <JWT_TOKEN>"
}
```

Request Body:

```json
{
    "category_name": "test_put"

```

Response Body Success:

```json
{
    {
        "data": {
            "id": 4,
            "category_name": "test_put"
        },
        "message": "Successfully updated category",
        "status": "success"
    }
}
```

Response Body Error:

```json
{
	"status":  "error",
	"message": "Category not found",
}
```json
{
	"status":  "error",
	"message": "Invalid data format,
}


## List category API

Endpoint : GET /api/api/category

Headers :

```json
{
    "Content-Type": "application/json"
}
```

Response Body Success:

```json
{
    "data": [
        {
            "id": 3,
            "category_name": "Cemilan"
        },
        {
            "id": 4,
            "category_name": "test_put"
        }
    ],
    "status": "success"
}
```

Response Body Error:

```json
{
  	"status":  "error",
	"message": "Failed to retrieve data categories",
}
```
Endpoint : GET /api/api/category/<id>

Headers :

```json
{
    "Content-Type": "application/json"
}
```

Response Body Success:

```json
{
    "data": [
        {
            "id": 4,
            "category_name": "test_put"
        }
    ],
    "status": "success"
}
```

Response Body Error:

```json
{
  	"status":  "error",
	"message": "Failed to retrieve data categories",
}
```


## Remove category API

Endpoint : DELETE /localhost/api/category/<id>

Headers :

```json
{
  "Content-Type": "application/json"
}
```

Response Body Success:

```json
{
    "message": "Successfully deleted category",
    "status": "success"
}
```

Response Body Error:

```json
{
	"status":  "error",
	"message": "Category not found",
}
```
