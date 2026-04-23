SQL
CREATE TABLE ugyfelek (
    id SERIAL PRIMARY KEY,
    nev VARCHAR(100) NOT NULL,
    cim VARCHAR(150),
    email VARCHAR(100),
    telefon VARCHAR(20)
);

CREATE TABLE jarmuvek (
    rendszam VARCHAR(10) PRIMARY KEY,
    tipus VARCHAR(50) NOT NULL,
    teherbiras INTEGER CHECK (teherbiras > 0)
);
