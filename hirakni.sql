/*customers table*/
CREATE TABLE customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  phone VARCHAR(20),
  address TEXT,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


/*appointment table */

CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  service VARCHAR(50) NOT NULL,
  appointment_date DATE NOT NULL,
  appointment_time TIME NOT NULL,
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE appointments ADD COLUMN status VARCHAR(20) DEFAULT 'pending';

/*services table */

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50),
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    image VARCHAR(255)
);

-- Hair Services
INSERT INTO services (category, name, description, price, image) VALUES
('Hair', 'Hair Cut', 'Professional haircut by trained stylists to match your style.', 350.00, '../images/haircut.jpg'),
('Hair', 'Hair Treatment', 'Nourishing treatment to restore health and shine.', 3499.00, '../images/treatment.jpg'),
('Hair', 'Hair Spa', 'Relaxing spa session to rejuvenate your hair.', 700.00, 'images/spa.jpg'),
('Hair', 'Hair Color', 'Trendy and vibrant hair coloring options available.', 1500.00, 'images/color.jpg');

-- Skin Services
INSERT INTO services (category, name, description, price, image) VALUES
('Skin', 'Eye Brows', 'Perfect shaping and trimming for clean brows.', 30.00, 'images/eyebrows.jpg'),
('Skin', 'Full Wax', 'Smooth full body waxing using premium products.', 500.00, 'images/fullwax.jpg'),
('Skin', 'Cream Wax', 'Gentle waxing solution for sensitive skin.', 300.00, 'images/creamwax.jpg'),
('Skin', 'Facial', 'Deep cleansing and rejuvenation facial treatment.', 500.00, 'images/facial.jpg'),
('Skin', 'Manicure', 'Nail shaping, cuticle care and polish.', 350.00, 'images/manicure.jpg'),
('Skin', 'Pedicure', 'Foot soak, scrub, and polish for silky feet.', 450.00, 'images/pedicure.jpg');

-- Makeup Services
INSERT INTO services (category, name, description, price, image) VALUES
('Makeup', 'Simple Makeup', 'Light everyday makeup for casual events.', 2000.00, 'images/simple.jpg'),
('Makeup', 'Semi HD Makeup', 'Professional makeup with semi HD finish.', 2500.00, 'images/semi_hd.jpg'),
('Makeup', 'HD Makeup', 'High-definition flawless makeup look.', 3000.00, 'images/hd.jpg');
-- Continued Makeup Services
INSERT INTO services (category, name, description, price, image) VALUES
('Makeup', 'Bridal Package', 'Complete bridal makeup and styling for your special day.', 0.00, 'images/bridal.jpg'),
('Makeup', 'Mehandi', 'Intricate traditional and modern henna designs.', 3999.00, 'images/mehandi.jpg'),
('Makeup', 'Haldi', 'Makeup and styling for haldi ceremony.', 3999.00, 'images/haldi.jpg'),
('Makeup', 'Sangeet', 'Festive makeup for your sangeet function.', 3999.00, 'images/sangeet.jpg'),
('Makeup', 'Wedding', 'Complete wedding makeup and dressing.', 7999.00, 'images/wedding.jpg'),
('Makeup', 'Reception', 'Elegant makeup and styling for the reception.', 4999.00, 'images/reception.jpg');

-- Academy Services
INSERT INTO services (category, name, description, price, image) VALUES
('Academy', 'Professional Beauty Courses', 'Join our certified beauty and wellness training programs to become an expert stylist or beautician.', 0.00, 'images/academy.jpg');


--contact Table

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Creating table for admin page
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);
INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(111, 'admin', 'admin@123');
