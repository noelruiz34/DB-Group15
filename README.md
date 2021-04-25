# DB-Group15
This is a mock point-of-sale system website, conceived for a database class project.

[Check out the project on herokuapp](https://point-of-sale-group15.herokuapp.com/)

## Project Requirements
- User authentication
  - Login system with constraints for both employees and custoemrs
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
  - Trigger upon Order Creation and Status Update, row will be appended to pending_emails table. 
  - Trigger upon Product dropping below set threshold (20) will append to pending_emails table.
  - Trigger upon Product reaching 0 quantity. If any customer has the product in their shopping cart it will be removed. 
- Data queries
  - View product info for product update
  - Product catalog
  - Shopping cart
  - Customer orders
  - Support ticket management
- Data Reports
  - Sales from orders and returns
  - Sales by products or catagories
  - Log of all changes to products by employees

## How To Install
