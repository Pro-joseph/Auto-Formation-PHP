SELECT SUM(price) AS total_inventory_value
FROM library_books;


SELECT COUNT(*) AS available_books
FROM library_books
WHERE status = 'Available';


SELECT 
    MAX(price) AS most_expensive,
    MIN(price) AS cheapest
FROM library_books;



SELECT AVG(price) AS average_price
FROM library_books;

