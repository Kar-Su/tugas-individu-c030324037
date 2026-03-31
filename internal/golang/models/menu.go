package models

type Menu struct {
	ID         int      `gorm:"column:id;primaryKey;autoIncrement" json:"id"`
	MenuName   string   `gorm:"column:menu_name;not null" json:"menu_name"`
	Price      float64  `gorm:"column:price;type:decimal(10,2);not null" json:"price"`
	CategoryID int      `gorm:"column:category_id;not null" json:"category_id"`
	Category   Category `gorm:"foreignKey:CategoryID" json:"category"`
}
