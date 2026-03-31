package models

type Category struct {
	ID           int    `gorm:"column:id;primaryKey;autoIncrement" json:"id"`
	CategoryName string `gorm:"column:category_name;not null" json:"category_name"`
}
