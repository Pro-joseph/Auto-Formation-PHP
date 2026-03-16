CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);


ALTER TABLE library_books
ADD category_id INT;


ALTER TABLE library_books
ADD CONSTRAINT category
FOREIGN KEY (category_id) REFERENCES categories(id);


SELECT 
    library_books.title,
    categories.name AS category
FROM library_books
JOIN categories 
ON library_books.category_id = categories.id;


INSERT INTO library_books WHERE category_id VALUES
('Programming'),
('Fantasy'),
('Science Fiction'),
('Classic Literature');


UPDATE library_books SET category_id = 1 WHERE title LIKE '%PHP%';
UPDATE library_books SET category_id = 2 WHERE title = 'The Hobbit';
UPDATE library_books SET category_id = 3 WHERE title = '1984';
UPDATE library_books SET category_id = 3 WHERE title = 'Animal Farm';
UPDATE library_books SET category_id = 4 WHERE title = 'The Great Gatsby';
UPDATE library_books SET category_id = 4 WHERE title = 'Moby Dick';
UPDATE library_books SET category_id = 4 WHERE title = 'To Kill a Mockingbird';
UPDATE library_books SET category_id = 4 WHERE title = 'The Catcher in the Rye';