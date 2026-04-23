# Költöztető Kft. Nyilvántartó Rendszer

Ez egy teljes körű, adatbázis-vezérelt webes alkalmazás, amely egy költöztető cég adminisztrációs feladatait támogatja. A projekt az ELTE adatbázisok kurzusára készült.

## Funkciók
 **CRUD műveletek:** Ügyfelek felvétele, listázása, módosítása és törlése.
 **Keresőrendszer:** Dinamikus szűrés (case-insensitive) a meglévő adatok között.
 **Vezetői Statisztikák:** Bonyolult SQL lekérdezések (JOIN, GROUP BY, Subquery) vizuális megjelenítése (pl. dolgozók bérezése, járműkihasználtság).
 **Biztonság:** SQL Injection elleni védelem paraméterezett lekérdezésekkel (`pg_query_params`).

##  Használt Technológiák
**Backend:** PHP 7/8
**Adatbázis:** PostgreSQL
**Frontend:** HTML5, CSS3

## Adatbázis Szerkezet
A rendszer relációs adatbázist használ. A táblák struktúrája (Ügyfelek, Járművek, Alkalmazottak, Megbízások, Munkavégzés) és a kapcsolatok a `database.sql` fájlban találhatók.
