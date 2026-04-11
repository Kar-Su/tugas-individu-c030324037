package main

import (
	"c030324037/go-api/configs"
	"c030324037/go-api/routes"

	"github.com/gofiber/fiber/v2"
<<<<<<< HEAD
=======
	"github.com/gofiber/fiber/v2/middleware/cors"
>>>>>>> 86532a0 (feat(frontend): make crud frontend)
)

func main() {
	configs.ConnectDB()
	app := fiber.New()
<<<<<<< HEAD
=======
	app.Use(cors.New())
>>>>>>> 86532a0 (feat(frontend): make crud frontend)
	routes.ApiRoutes(app)
	app.Listen(":8080")
}
