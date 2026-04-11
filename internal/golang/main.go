package main

import (
	"c030324037/go-api/configs"
	"c030324037/go-api/routes"

	"github.com/gofiber/fiber/v2"
	"github.com/gofiber/fiber/v2/middleware/cors"
)

func main() {
	configs.ConnectDB()
	app := fiber.New()
	app.Use(cors.New())
	routes.ApiRoutes(app)
	app.Listen(":8080")
}
