# order API Spec

## Create order API

Endpoint : POST /localhost/api/order

Headers :

```json
{
  "Content-Type": "application/json",
}
```

Request Body:
(REQUAIRE user_id AND total_price MINIMAL)
```json
{
    "total_price":12000,
    "user_id":2
}
```

Response Body Success:

```json
{
    "status": "success",
    "message": "Successfully created order",
    "data": {
        "user_id": 2,
        "total_price": 12000,
        "id": "1"
    }
}
```

Response Body Error:

```json
{
	"status":  "error",
	"message": "Failed to retrieve data order",
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
	"message": "Failed to save data order",
}
```

## Update order API

Endpoint : PUT /localhost/api/order/<id>

Headers :

```json
{
  "Content-Type": "application/json",
}
```

Request Body:
(ONLY EDIT STATUS)
```json
{
    "price": 1

```

Response Body Success:

```json
{
    "status": "success",
    "message": "Successfully updated order status",
    "data": {
        "id": 1,
        "user_id": 2,
        "status": "Diproses",
        "total_price": "12000.00",
        "created_at": "2026-03-31 12:52:20",
        "updated_at": "2026-03-31 12:54:29"
    }
}
```

Response Body Error:

```json
{
	"status":  "error",
	"message": "order not found",
}
```

```json
{
	"status":  "error",
	"message": "Invalid data format,
}
```

## List order API

Endpoint : GET /api/api/order

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
            "id": 1,
            "user_id": 2,
            "status": "Diproses",
            "total_price": "12000.00",
            "created_at": "2026-03-31 12:52:20",
            "updated_at": "2026-03-31 12:54:29"
        },
        {
            "id": 2,
            "user_id": 1,
            "status": "Diproses",
            "total_price": "15000.00",
            "created_at": "2026-03-31 12:52:20",
            "updated_at": "2026-03-31 12:54:29"
        }
    ]
}
```

Response Body Error:

```json
{
  	"status":  "error",
	"message": "Failed to retrieve data order",
}
```
Endpoint : GET /api/api/order/<id>

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
        "id": 1,
        "user_id": 2,
        "status": "Diproses",
        "total_price": "12000.00",
        "created_at": "2026-03-31 12:52:20",
        "updated_at": "2026-03-31 12:54:29"
    }
}
```

Response Body Error:

```json
{
  	"status":  "error",
	"message": "Failed to retrieve data order",
}
```


## Remove order API

Endpoint : DELETE /localhost/api/order/<id>

Headers :

```json
{
  "Content-Type": "application/json"
}
```

Response Body Success:

```json
{
    "message": "Successfully deleted order",
    "status": "success"
}
```

Response Body Error:

```json
{
	"status":  "error",
	"message": "order not found",
}
```
