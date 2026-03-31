package routes

import (
	"c030324037/go-api/auth"
	"c030324037/go-api/controllers"

	"github.com/gofiber/fiber/v2"
)

func ApiRoutes(app *fiber.App) {
	api := app.Group("/api")

	// Menu
	menu := api.Group("/menu")
	menu.Get("/", controllers.GetMenu)
	menu.Get("/:id", controllers.GetMenuById)
	menu.Post("/", auth.JWT("Admin"), controllers.CreateMenu)
	menu.Put("/:id", auth.JWT("Admin"), controllers.UpdateMenu)
	menu.Delete("/:id", auth.JWT("Admin"), controllers.DeleteMenu)

	// Category
	category := api.Group("/category")
	category.Get("/", controllers.GetCategories)
	category.Get("/:id", controllers.GetCategoriesById)
	category.Post("/", auth.JWT("Admin"), controllers.CreateCategory)
	category.Put("/:id", auth.JWT("Admin"), controllers.UpdateCategory)
	category.Delete("/:id", auth.JWT("Admin"), controllers.DeleteCategory)
}
