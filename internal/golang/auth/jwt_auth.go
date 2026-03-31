package auth

import (
	"os"
	"strings"

	"github.com/gofiber/fiber/v2"
	"github.com/golang-jwt/jwt/v5"
)

func JWT(roleRequired string) fiber.Handler {
	return func(c *fiber.Ctx) error {
		authHeader := c.Get("Authorization")
		if authHeader == "" {
			return c.Status(401).JSON(fiber.Map{"message": "No token provided"})
		}

		tokenString := strings.Replace(authHeader, "Bearer ", "", 1)
		secretKey := []byte(os.Getenv("SECRET_JWT"))

		token, err := jwt.Parse(tokenString, func(token *jwt.Token) (any, error) {
			return secretKey, nil
		})

		if err != nil || !token.Valid {
			return c.Status(401).JSON(fiber.Map{"message": "Token invalid or expired", "tokenasli": tokenString, "tokenanda": authHeader})
		}

		claims := token.Claims.(jwt.MapClaims)
		userRole, ok := claims["role"].(string)

		if !ok {
			userRole = ""
		}

		if roleRequired != "" && userRole != roleRequired {
			return c.Status(403).JSON(fiber.Map{"message": "You are unauthorized (only " + roleRequired + ")"})
		}

		return c.Next()
	}
}
