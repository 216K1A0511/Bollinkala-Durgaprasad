# Madlibs Word Game (Human-Style)

print("Welcome to Madlibs!")
print("Let's have fun. You'll enter some words, and together we'll make a silly story.\n")

# Friendly prompts for user input
user_name = input("What's a person's name? ")
fav_place = input("Name a place: ")
random_noun = input("Give me a random object (noun): ")
funny_adj = input("Describe something with an adjective: ")
doing_verb = input("What is something you do? (verb ending in -ing): ")

# Human-readable story template
story = (
    f"\nHere's your story!\n"
    f"---------------------------------\n"
    f"One fine day, {user_name} decided to visit {fav_place}. "
    f"While exploring, {user_name} stumbled upon a very {funny_adj} {random_noun}. "
    f"Without thinking, {user_name} started {doing_verb} with it, causing everyone around to laugh out loud. "
    f"It turned out to be the most unforgettable trip to {fav_place} ever!\n"
)

# Final output with extra line for clarity
print(story)
print("Thanks for playing Madlibs! Hope you had a laugh.")
