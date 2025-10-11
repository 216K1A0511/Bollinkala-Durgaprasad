import json
import os
import base64
import getpass
from cryptography.fernet import Fernet
from cryptography.hazmat.primitives.kdf.pbkdf2 import PBKDF2HMAC
from cryptography.hazmat.primitives import hashes
from cryptography.hazmat.backends import default_backend
import secrets
import string

# --- Helper Functions ---

def derive_key(password, salt):
    # Use PBKDF2HMAC to derive a key from the master password and salt
    kdf = PBKDF2HMAC(
        algorithm=hashes.SHA256(),
        length=32,
        salt=salt,
        iterations=100_000,
        backend=default_backend()
    )
    return base64.urlsafe_b64encode(kdf.derive(password.encode()))

def load_salt():
    if not os.path.exists('.salt'):
        salt = os.urandom(16)
        with open('.salt', 'wb') as f:
            f.write(salt)
    else:
        with open('.salt', 'rb') as f:
            salt = f.read()
    return salt

def get_fernet(master_password):
    salt = load_salt()
    key = derive_key(master_password, salt)
    return Fernet(key)

def generate_password(length=16):
    alphabet = string.ascii_letters + string.digits + string.punctuation
    return ''.join(secrets.choice(alphabet) for _ in range(length))

# --- Core Functions ---

def add_entry(master_password, website, username):
    password = generate_password()
    f = get_fernet(master_password)
    if not os.path.exists('vault.json'):
        db = []
    else:
        with open('vault.json', 'r') as file:
            try:
                db = json.load(file)
            except json.JSONDecodeError:
                db = []
    entry = {
        'website': website,
        'username': username,
        'password': f.encrypt(password.encode()).decode()
    }
    db.append(entry)
    with open('vault.json', 'w') as file:
        json.dump(db, file, indent=4)
    print(f"\nSaved credentials for {website}.")
    print(f"Random strong password: {password}")

def get_entry(master_password, website):
    f = get_fernet(master_password)
    if not os.path.exists('vault.json'):
        print("No vault found.")
        return
    with open('vault.json', 'r') as file:
        db = json.load(file)
    for entry in db:
        if entry['website'].lower() == website.lower():
            dec_password = f.decrypt(entry['password'].encode()).decode()
            print(f"Website: {entry['website']}")
            print(f"Username: {entry['username']}")
            print(f"Password: {dec_password}")
            return
    print(f"No entry found for {website}.")

# --- Main CLI ---

def menu():
    print("Random Password Manager")
    print("1. Add new entry")
    print("2. Retrieve entry")
    print("3. Exit")
    return input("Choose an option: ")

if __name__ == "__main__":
    while True:
        choice = menu()
        if choice == '1':
            master_password = getpass.getpass("Master Password: ")
            website = input("Website: ")
            username = input("Username/Email: ")
            add_entry(master_password, website, username)
        elif choice == '2':
            master_password = getpass.getpass("Master Password: ")
            website = input("Website to retrieve: ")
            get_entry(master_password, website)
        elif choice == '3':
            break
        else:
            print("Invalid choice.")

