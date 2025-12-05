import os

# Define the structure
structure = {
    "mini-ctf-burpsuite-practice": {
        "": ["index.php", "secret_admin_dashboard.php", "README.md"],
        "api": ["profile.php"]
    }
}

def create_structure(base_path, structure):
    for folder, contents in structure.items():
        folder_path = os.path.join(base_path, folder)
        os.makedirs(folder_path, exist_ok=True)
        
        for subfolder, files in contents.items() if isinstance(contents, dict) else [("", contents)]:
            subfolder_path = os.path.join(folder_path, subfolder) if subfolder else folder_path
            os.makedirs(subfolder_path, exist_ok=True)
            
            for file in files:
                file_path = os.path.join(subfolder_path, file)
                with open(file_path, "w") as f:
                    f.write("")  # creates empty file

if __name__ == "__main__":
    base_dir = "."  # current directory
    create_structure(base_dir, structure)
    print("CTF practice structure created successfully!")