# menu API Spec

## Create menu API

Endpoint : POST /localhost/api/menu

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
    "menu_name":"post_test",
    "price":150000,
    "category_id":1
}
```

Response Body Success:

```json
{
    "data": {
        "id": 4,
        "menu_name": "post_test",
        "price": 150000,
        "category_id": 1,
        "category": {
            "id": 1,
            "category_name": "Makanan Utama"
        }
    },
    "message": "Successfully added menu",
    "status": "success"
}
```

Response Body Error:

```json
{
	"status":  "error",
	"message": "Failed to retrieve data menu",
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
	"message": "Failed to save data menu",
}
```

## Update menu API

Endpoint : PUT /localhost/api/menu/<id>

Headers :

```json
{
  "Content-Type": "application/json",
  "Authorization": "Bearer <JWT_TOKEN>"
}
```

Request Body:
(AVAILABLE TO EDIT ANY FIELD)
```json
{
    "price": 1

```

Response Body Success:

```json
{
    "data": {
        "id": 4,
        "menu_name": "post_test",
        "price": 1,
        "category_id": 1,
        "category": {
            "id": 1,
            "category_name": "Makanan Utama"
        }
    },
    "message": "Successfully updated menu",
    "status": "success"
}
```

Response Body Error:

```json
{
	"status":  "error",
	"message": "menu not found",
}
```json
{
	"status":  "error",
	"message": "Invalid data format,
}
```

## List menu API

Endpoint : GET /api/api/menu

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
            "menu_name": "Kerupuk",
            "price": 5000,
            "category_id": 3,
            "category": {
                "id": 3,
                "category_name": "Cemilan"
            }
        },
        {
            "id": 4,
            "menu_name": "post_test",
            "price": 1,
            "category_id": 1,
            "category": {
                "id": 1,
                "category_name": "Makanan Utama"
            }
        }
    ],
    "status": "success"
}
```

Response Body Error:

```json
{
  	"status":  "error",
	"message": "Failed to retrieve data menu",
}
```
Endpoint : GET /api/api/menu/<id>

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
            "menu_name": "post_test",
            "price": 1,
            "category_id": 1,
            "category": {
                "id": 1,
                "category_name": "Makanan Utama"
            }
        }
    ],
    "status": "success"
}
```

Response Body Error:

```json
{
  	"status":  "error",
	"message": "Failed to retrieve data menu",
}
```


## Remove menu API

Endpoint : DELETE /localhost/api/menu/<id>

Headers :

```json
{
  "Content-Type": "application/json"
}
```

Response Body Success:

```json
{
    "message": "Successfully deleted menu",
    "status": "success"
}
```

Response Body Error:

```json
{
	"status":  "error",
	"message": "menu not found",
}
```
