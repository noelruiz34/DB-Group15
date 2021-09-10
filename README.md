# DB-Group15

This is a mock point-of-sale system website, conceived for a database class project.

[Check out the project on herokuapp](https://point-of-sale-group15.herokuapp.com/)

## Project Requirements
- User authentication
  - Login system with constraints for both employees and customers
  - Customers registration ensures all data entered is valid
  - Employees are not allowed to create accounts, someone with database access must create accounts
- Data entry forms
  - Customer Registration
  - Edit customer account info
  - Create a support ticket
  - Add products to cart
  - Add update/products
  - Issue returns
- Triggers
1) When new order is created, the order status is initialized as “Processing”.
2) After this new order is created, an email is generated to let the customer know that their order is on its way.
3) When an order status gets updated (by an employee), if the new order status is not the same as the old order status then send a new email to let the customer's know of the update.
4) If the inventory count of an item is less than or equal to 20 then send an email to employees to let them know so that they can be informed to add more inventory.
5) When a refund is initiated a record of the time is kept.
6) When a support ticket is created a timestamp is generated and the ticket status is initialized as “Needs Review”. 
- Data queries
  - View product info for product update
  - Product catalog
  - Shopping cart
  - Customer orders
  - Support ticket management
- Data Reports
  - Sales from orders and returns
  - Sales by products or categories
  - Log of all changes to products by employees

## How To Install



