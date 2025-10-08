import os
import shutil

def get_human_categories():
    print("Create your own sorting rules! For each folder, enter its name and matching words (extensions or keywords).")
    categories = {}
    while True:
        folder = input("Enter category folder name (or 'done' to finish): ").strip()
        if folder.lower() == 'done':
            break
        words = input(f"Enter extensions or keywords for '{folder}', separated by commas (e.g., .jpg,report): ")
        categories[folder] = [w.strip().lower() for w in words.split(',')]
    return categories

def organize_files(directory_path, categories):
    for filename in os.listdir(directory_path):
        file_path = os.path.join(directory_path, filename)
        if os.path.isfile(file_path):
            file_extension = os.path.splitext(filename)[1].lower()
            moved = False
            for folder, words in categories.items():
                if file_extension in words:
                    moved = True
                else:
                    for word in words:
                        if word and word in filename.lower():
                            moved = True
                            break
                if moved:
                    dest_folder = os.path.join(directory_path, folder)
                    os.makedirs(dest_folder, exist_ok=True)
                    shutil.move(file_path, os.path.join(dest_folder, filename))
                    print(f"Moved '{filename}' to '{folder}/'")
                    break
            if not moved:
                print(f"No matching category for '{filename}'.")

directory = input("Enter the directory path to organize: ")
user_categories = get_human_categories()
organize_files(directory, user_categories)
