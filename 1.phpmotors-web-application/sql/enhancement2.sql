--QUERIES TO INTO THE CLIENTS TABLE - PHPMOTORS DATABASE


-- NUMBER 1 - Insert new client to the clients table 
INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword, comment) VALUES 
('Tony', 'Stark', 'tony@starkent.com', 'IamIronM@n', 'I am the real ironman');


--NUMBER 2- Modify the Tony Stark record to change the clientLevel to 3 
UPDATE clients SET clientLevel = 3 WHERE clientid = 1


--NUMBER 3 - Modify the "GM Hummer" record to read "spacious interior" rather than "small interior"
UPDATE inventory SET invDescription = REPLACE(invDescription, 'small interior', 'spacious interior')
WHERE invId = 12


--NUMBER 4 - Use an inner join / "SUV" category.
SELECT inventory.invModel, carclassification.classificationName FROM inventory INNER JOIN 
carclassification ON inventory.classificationId=carclassification.classificationId
WHERE inventory.classificationId = 1


--NUMBER 5 - Delete the Jeep Wrangler from the database.
DELETE from inventory WHERE invId = 1


--NUMBER 6 - Update all records in the Inventory table to add "/phpmotors" 
UPDATE inventory SET invImage=concat('/phpmotors',invImage),invThumbnail=concat('/phpmotors',invThumbnail)







