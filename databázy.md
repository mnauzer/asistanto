# Štruktúra a vzťahy databáz

## Základné delenie aplikácie

### Databázy:

#### Osoby:
- **Zamestnanci** (zoznam zamestnancov)
  *polia databázy:*
  - číslo
  - meno
  - priezvisko
  - nick (jedinečný textový identifikátor, human readable)
  - zaradenie (vedúcko, zamestnanec, brigádnik, externý)
  - is_active
  - adresa (Miesto)
  - **Zamestnanci_sadzby** (pomocná tabuľka s hodinovými sadzbami)

- **Dodávatelia** (dodávatelia tovarov, materiálu a služieb)
  *polia databázy:*
  - číslo
  - názov
  - nick (jedinečný textový identifikátor, human readable)
  - ico
  - dic
  - is_active
  - adresa (Miesto)

- **Klienti** (zákazníci, môžu byť súkromné osoby a firmy)
  *polia databázy:*
  - číslo
  - firma/súkromná osoba
  - nick (jedinečný textový identifikátor, human readable)
  - titul
  - meno
  - priezvisko
  - názov firmy
  - ico
  - dic
  - is_plátca dph
  - is_active
  - adresa (Miesto)

- **Partneri** (všetci ostatní, ktorí nespadajú do prvých troch skupín)
  *polia databázy:*
  - číslo
  - firma/súkromná osoba
  - nick (jedinečný textový identifikátor, human readable)
  - titul
  - meno
  - priezvisko
  - názov firmy
  - ico
  - dic
  - is_plátca dph
  - is_active
  - adresa (Miesto)

#### Veci:
- **Sklad**
  materiály, tovary s nákupnými a predajnými cenami a evidenciou aktuálneho stavu
- **Cenník prác**
  aktuálne ceny
- **Stroje**
  stroje používané pri našej činnosti, vlastné aj externé
- **Vozidlá**
  vozidlá používané pri našej činnosti – len vlastné
- **Miesta**
  konkrétne miesta s GPS súradnicami a adresou, ktoré budú použité pri ďalších záznamoch (miesto realizácie, miesto dodávateľa a pod.). Tieto záznamy budú použité aj pre evidenciu dopravy a výpočet prejazdených km.
- **Účty**
  zoznam bankových a hotovostných účtov

#### Evidencia:
- **Dochádzka**
  evidencia
