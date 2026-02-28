-- 1. AGENCIES (Users)
CREATE TABLE agencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL, -- The Agency Name
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT 'default.png',
    reputation INT DEFAULT 0, -- Gamification Score
    role ENUM('admin', 'creative') DEFAULT 'creative',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. BRIEFS (Challenges)
CREATE TABLE briefs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agency_id INT NOT NULL, -- Who posted the brief?
    title VARCHAR(100) NOT NULL, -- e.g., "Sell this Brick"
    description TEXT NOT NULL,
    category VARCHAR(50), -- e.g., "Tech", "Food", "Absurd"
    image VARCHAR(255), -- Product image to Photoshop
    deadline DATETIME NOT NULL,
    FOREIGN KEY (agency_id) REFERENCES agencies(id) ON DELETE CASCADE
);

-- 3. ADS (Submissions)
CREATE TABLE ads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brief_id INT NOT NULL,
    agency_id INT NOT NULL, -- The Creator
    slogan VARCHAR(255), -- The Catchy Text
    image_path VARCHAR(255) NOT NULL, -- The Photoshoped Image
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (brief_id) REFERENCES briefs(id) ON DELETE CASCADE,
    FOREIGN KEY (agency_id) REFERENCES agencies(id) ON DELETE CASCADE
);

-- 4. VOTES (The Judgment)
CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ad_id INT NOT NULL,
    agency_id INT NOT NULL, -- Who voted
    value INT DEFAULT 1,
    UNIQUE(ad_id, agency_id), -- Prevent double voting
    FOREIGN KEY (ad_id) REFERENCES ads(id) ON DELETE CASCADE
);

-- 5. COMMENTS (Feedback)
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ad_id INT NOT NULL,
    agency_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ad_id) REFERENCES ads(id) ON DELETE CASCADE
);