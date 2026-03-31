package main

import (
	"c030324037/go-api/configs"
	"c030324037/go-api/routes"

	"github.com/gofiber/fiber/v2"
)

func main() {
	configs.ConnectDB()
	app := fiber.New()
	routes.ApiRoutes(app)
	app.Listen(":8080")
}
