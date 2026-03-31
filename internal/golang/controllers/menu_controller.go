package controllers

import (
	"c030324037/go-api/configs"
	"c030324037/go-api/models"

	"github.com/gofiber/fiber/v2"
)

func GetMenu(c *fiber.Ctx) error {
	var menu []models.Menu

	if err := configs.DB.Preload("Category").Find(&menu).Error; err != nil {
		return c.Status(500).JSON(fiber.Map{
			"status":  "error",
			"message": "Failed to retrieve data menu",
		})
	}

	return c.JSON(fiber.Map{
		"status": "success",
		"data":   menu,
	})
}

func GetMenuById(c *fiber.Ctx) error {
	var menu []models.Menu
	id := c.Params("id")

	if err := configs.DB.Preload("Category").First(&menu, id).Error; err != nil {
		return c.Status(500).JSON(fiber.Map{
			"status":  "error",
			"message": "Failed to retrieve data menu",
		})
	}

	return c.JSON(fiber.Map{
		"status": "success",
		"data":   menu,
	})
}

func CreateMenu(c *fiber.Ctx) error {
	var menu models.Menu

	if err := c.BodyParser(&menu); err != nil {
		return c.Status(400).JSON(fiber.Map{
			"status":  "error",
			"message": "Invalid data format",
		})
	}

	if err := configs.DB.Create(&menu).Error; err != nil {
		return c.Status(500).JSON(fiber.Map{
			"status":  "error",
			"message": "Failed to save data menu",
		})
	}

	configs.DB.Preload("Category").First(&menu, menu.ID)

	return c.Status(201).JSON(fiber.Map{
		"status":  "success",
		"message": "Successfully added menu",
		"data":    menu,
	})
}

func UpdateMenu(c *fiber.Ctx) error {
	id := c.Params("id")
	var menu models.Menu

	if err := configs.DB.First(&menu, id).Error; err != nil {
		return c.Status(404).JSON(fiber.Map{
			"status":  "error",
			"message": "Menu not found",
		})
	}

	var updateData models.Menu
	if err := c.BodyParser(&updateData); err != nil {
		return c.Status(400).JSON(fiber.Map{
			"status":  "error",
			"message": "Invalid data format",
		})
	}

	configs.DB.Model(&menu).Updates(updateData)

	configs.DB.Preload("Category").First(&menu, menu.ID)

	return c.JSON(fiber.Map{
		"status":  "success",
		"message": "Successfully updated menu",
		"data":    menu,
	})
}

func DeleteMenu(c *fiber.Ctx) error {
	id := c.Params("id")
	var menu models.Menu

	if err := configs.DB.First(&menu, id).Error; err != nil {
		return c.Status(404).JSON(fiber.Map{
			"status":  "error",
			"message": "Menu not found",
		})
	}

	configs.DB.Delete(&menu)

	return c.JSON(fiber.Map{
		"status":  "success",
		"message": "Successfully deleted menu",
	})
}
