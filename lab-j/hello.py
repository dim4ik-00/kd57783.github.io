import sys

name = "Dmytro"
album = 57783
python_version = f"{sys.version_info.major}.{sys.version_info.minor}.{sys.version_info.micro}"
location = sys.executable

print(
    f"Hello {name} ({album}). This environment is using Python version "
    f"{python_version} at location {location}."
)
