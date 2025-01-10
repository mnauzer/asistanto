# Asistanto

Asistanto je projekt na automatizáciu a organizáciu úloh pomocou moderných webových technológií. Tento projekt obsahuje frontend aj backend časť, ktoré spolupracujú cez REST API.

## Obsah
- [Požiadavky](#požiadavky)
- [Inštalácia](#inštalácia)
- [Použitie](#použitie)
- [Prispievanie](#prispievanie)
- [Licencia](#licencia)

---

## Požiadavky

- Docker a Docker Compose (najnovšia verzia)
- Node.js (verzia 18.x alebo vyššia)
- NPM alebo Yarn
- Git

## Inštalácia

1. Naklonuj repozitár:
   ```bash
   git clone https://github.com/mnauzer/asistanto.git
   cd asistanto
   ```

2. Spusti inštaláciu závislostí pre frontend:
   ```bash
   cd frontend
   npm install
   ```

3. Spusti inštaláciu závislostí pre backend (ak existuje backend):
   ```bash
   cd backend
   npm install
   ```

4. Spusti Docker Compose:
   ```bash
   docker-compose up --build
   ```

5. Over, že aplikácia beží:
   - Frontend: [http://localhost:3000](http://localhost:3000)
   - Backend: [http://localhost:8000](http://localhost:8000)

---

## Použitie

1. Otvor aplikáciu vo webovom prehliadači na URL [http://localhost:3000](http://localhost:3000).
2. Prihlás sa alebo si vytvor nový účet (ak to aplikácia podporuje).
3. Prechádzaj funkcionality a pridávaj úlohy na automatizáciu.

---

## Prispievanie

Ak chceš prispieť do projektu:

1. Vytvor novú vetvu pre svoju funkcionalitu alebo opravu:
   ```bash
   git checkout -b feature/nova-funkcionalita
   ```
2. Urob potrebné zmeny a pridaj ich:
   ```bash
   git add .
   git commit -m "Pridanie novej funkcionality"
   ```
3. Odosli svoje zmeny:
   ```bash
   git push origin feature/nova-funkcionalita
   ```
4. Vytvor pull request na GitHube a počkaj na schválenie.

---

## Licencia

Tento projekt je licencovaný pod MIT licenciou. Podrobnosti nájdeš v súbore [LICENSE](LICENSE).

---

Ak máš akékoľvek otázky alebo problémy, neváhaj ma kontaktovať cez Issues na GitHube.

