# Random Password Manager

A CLI-based, secure password manager for storing and retrieving credentials using file handling and encrypted storage.

## Features

- **Secure encryption:** Uses a master password to encrypt credentials with PBKDF2 and Fernet.[1]
- **Random password generator:** Creates strong, unpredictable passwords for each new credential.[1]
- **Simple CLI menu:** Add and retrieve entries with an easy-to-use interface.[3][1]
- **File-based vault:** Credentials are securely stored in `vault.json`.[1]
- **Salt Storage:** Cryptographic salt stored separately for extra security.[1]

## How It Works

- When adding a new entry, the tool generates a strong random password, encrypts it, and saves to the vault file.
- Retrieval requires the master password and website name; the tool decrypts and displays stored data.
- Salt is stored in `.salt` to ensure unique key derivation per vault.

## Setup and Installation

1. Clone the repository:
   ```
   git clone https://github.com/<your-username>/random-password-manager.git
   cd random-password-manager
   ```

2. Install dependencies:
   ```
   pip install cryptography
   ```

3. Run the tool:
   ```
   python password_manager.py
   ```

## Usage

- **Add a new entry:**  
  Select option 1 in the menu, enter your master password, website, and username/email. A strong password is generated, encrypted, and stored.

- **Retrieve an entry:**  
  Select option 2, enter your master password and website name to view credentials.

- **Exit:**  
  Select option 3 to quit.

## Security Notes

- Uses strong PBKDF2 key derivation and Fernet symmetric encryption.
- Master password should be long and unique – do not lose it!
- Vault file (`vault.json`) and salt (`.salt`) should be kept secret.
- Project is for educational/demo use; review real-world security best practices before personal deployment.

## Example

```
Random Password Manager
1. Add new entry
2. Retrieve entry
3. Exit
```

## Possible Extensions

- Add database support for multi-device sync.
- Integrate a GUI (Tkinter or PyQt).
- Auto-fill passwords in browsers.
- Password strength checker.
- User authentication and two-factor support.

## License

MIT License

Copyright (c) 2025 [Bollinkala Durgaprasad]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
