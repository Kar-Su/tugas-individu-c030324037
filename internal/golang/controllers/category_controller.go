package controllers

import (
	"c030324037/go-api/configs"
	"c030324037/go-api/models"

	"github.com/gofiber/fiber/v2"
)

func GetCategories(c *fiber.Ctx) error {
	var categories []models.Category

	if err := configs.DB.Find(&categories).Error; err != nil {
		return c.Status(500).JSON(fiber.Map{
			"status":  "error",
			"message": "Failed to retrieve data categories",
		})
	}

	return c.JSON(fiber.Map{
		"status": "success",
		"data":   categories,
	})
}
func GetCategoriesById(c *fiber.Ctx) error {
	var categories []models.Category
	id := c.Params("id")

	if err := configs.DB.First(&categories, id).Error; err != nil {
		return c.Status(500).JSON(fiber.Map{
			"status":  "error",
			"message": "Failed to retrieve data categories",
		})
	}

	return c.JSON(fiber.Map{
		"status": "success",
		"data":   categories,
	})
}

func CreateCategory(c *fiber.Ctx) error {
	var category models.Category

	if err := c.BodyParser(&category); err != nil {
		return c.Status(400).JSON(fiber.Map{
			"status":  "error",
			"message": "Invalid data format",
		})
	}

	if err := configs.DB.Create(&category).Error; err != nil {
		return c.Status(500).JSON(fiber.Map{
			"status":  "error",
			"message": "Failed to save data category",
		})
	}

	return c.Status(201).JSON(fiber.Map{
		"status":  "success",
		"message": "Successfully added category",
		"data":    category,
	})
}

func UpdateCategory(c *fiber.Ctx) error {
	id := c.Params("id")
	var category models.Category

	if err := configs.DB.First(&category, id).Error; err != nil {
		return c.Status(404).JSON(fiber.Map{
			"status":  "error",
			"message": "Category not found",
		})
	}

	var updateData models.Category
	if err := c.BodyParser(&updateData); err != nil {
		return c.Status(400).JSON(fiber.Map{
			"status":  "error",
			"message": "Invalid data format",
		})
	}

	configs.DB.Model(&category).Updates(updateData)

	return c.JSON(fiber.Map{
		"status":  "success",
		"message": "Successfully updated category",
		"data":    category,
	})
}

func DeleteCategory(c *fiber.Ctx) error {
	id := c.Params("id")
	var category models.Category

	if err := configs.DB.First(&category, id).Error; err != nil {
		return c.Status(404).JSON(fiber.Map{
			"status":  "error",
			"message": "Category not found",
		})
	}

	configs.DB.Delete(&category)

	return c.JSON(fiber.Map{
		"status":  "success",
		"message": "Successfully deleted category",
	})
}
