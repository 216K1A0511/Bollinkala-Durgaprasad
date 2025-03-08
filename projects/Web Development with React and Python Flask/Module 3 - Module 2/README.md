
Module 2  HTML, CSS, and JavaScript Essentials 
HTML Basics 
1. Overview of HTML Structure and Semantic Elements 
Basic Structure of an HTML Document 
HTML (HyperText Markup Language) provides the foundation for creating web pages. A 
standard HTML document has the following structure: 
<!DOCTYPE html> 
<html> 
<head> 
<title>My Web Page</title> 
</head> 
<body> 
<h1>Welcome to My Website</h1> 
<p>This is an example of a basic HTML document structure.</p> 
</body> 
</html> 
Explanation: 
• <!DOCTYPE html>: Declares the document type as HTML5. 
• <html>: Root element of the HTML document. 
• <head>: Contains metadata such as the title, character set, and links to stylesheets or 
scripts. 
• <title>: Specifies the title of the web page that appears on the browser tab. 
• <body>: Contains all the visible content of the web page, such as text, images, and videos. 
Semantic Elements 
Semantic elements clearly describe their purpose and content. They improve accessibility, 
readability, and SEO. 
1. <header>: Represents the header section, often containing navigation or introductory 
content. 
<header> 
<h1>Welcome to My Website</h1> 
<nav> 
<ul> 
<li><a href="#home">Home</a></li> 
<li><a href="#about">About</a></li> 
<li><a href="#contact">Contact</a></li> 
</ul> 
</nav> 
</header> 
2. <footer>: Represents the footer section, typically containing copyright information 
or links. 
<footer> 
<p>&copy; 2024 My Website. All rights reserved.</p> 
</footer> 
3. <section>: Defines a thematic grouping of content. 
<section id="about"> 
<h2>About Us</h2> 
<p>We provide interactive learning experiences.</p> 
</section> 
4. <nav>: Represents a navigation menu. 
<nav> 
<ul> 
<li><a href="#home">Home</a></li> 
<li><a href="#services">Services</a></li> 
<li><a href="#contact">Contact</a></li> 
</ul> 
</nav> 
2. Creating Forms 
Forms are used to collect user input and send it to the server. 
Form Elements 
1. <input>: Accepts user input. 
<form action="/submit" method="POST"> 
<label for="name">Name:</label> 
<input type="text" id="name" name="name" required> 
</form> 
o Attributes: 
▪ type: Specifies the type of input (e.g., text, email, password). 
▪ name: Specifies the name of the input field. 
▪ id: Links the input to a label for accessibility. 
▪ required: Ensures the field must be filled before submission. 
2. <textarea>: Allows multi-line text input. 
<label for="message">Message:</label> 
<textarea id="message" name="message" rows="4" cols="50"></textarea> 
3. <button>: Submits the form or performs a custom action. 
<button type="submit">Submit</button> 
Validation Attributes 
1. required: Makes a field mandatory. 
<input type="email" name="email" required> 
2. maxlength: Limits the maximum number of characters. 
<input type="text" name="username" maxlength="10"> 
3. pattern: Specifies a regex pattern for validation. 
<input type="text" name="phone" pattern="\d{10}" 
placeholder="1234567890"> 
3. Embedding Media and Interactive Elements 
Using <img> to Display Images 
The <img> tag embeds images into the webpage. 
Example: 
<img src="logo.png" alt="Company Logo" width="200" height="100"> 
• Attributes: 
o src: Specifies the path to the image file. 
o alt: Provides alternative text for accessibility. 
o width/height: Sets the dimensions of the image. 
Embedding Videos with <video> 
The <video> tag embeds videos and provides playback controls. 
Example: 
<video width="320" height="240" controls> 
<source src="example.mp4" type="video/mp4"> 
<source src="example.ogg" type="video/ogg"> 
Your browser does not support the video tag. 
</video> 
• Attributes: 
o controls: Adds playback controls like play, pause, and volume. 
o width/height: Sets the video dimensions. 
o source: Specifies video files with different formats for compatibility. 
Drawing Graphics with <canvas> 
The <canvas> tag is used for rendering graphics via JavaScript. 
Example: 
<canvas id="myCanvas" width="200" height="100" style="border:1px solid 
#000000;"></canvas> 
<script> 
const canvas = document.getElementById("myCanvas"); 
const ctx = canvas.getContext("2d"); 
ctx.fillStyle = "blue"; 
ctx.fillRect(20, 20, 150, 50); 
</script> 
• Attributes: 
o id: Identifies the canvas element. 
o width/height: Specifies the size of the canvas. 
• JavaScript Methods: 
o getContext("2d"): Retrieves the 2D drawing context. 
o fillRect(x, y, width, height): Draws a rectangle on the canvas. 
CSS Fundamentals 
1. Understanding the Box Model 
The box model describes the rectangular boxes that are generated for elements in the layout. 
It consists of the following layers: 
1. Content: The actual content inside the element, such as text, images, or other elements. 
2. Padding: The space between the content and the border. 
3. Border: The edge of the element. It surrounds the padding and content. 
4. Margin: The space outside the border, separating the element from other elements. 
Visualization of the Box Model: 
+-----------------------------+ 
|          Margin             | 
+-----------------------------+ 
|          Border             | 
+-----------------------------+ 
|          Padding            | 
+-----------------------------+ 
|         Content             | 
+-----------------------------+ 
Example: 
<div style="width: 200px; padding: 10px; border: 5px solid black; margin: 
15px;"> 
Box Model Example 
</div> 
Explanation: 
• width: Sets the content width (200px in this case). 
• padding: Adds space (10px) inside the border around the content. 
• border: Adds a 5px black border around the padding. 
• margin: Creates a 15px gap outside the border. 
2. Positioning and Display Properties 
CSS provides properties to control the layout and positioning of elements on a web page. 
Positioning 
1. Static (default): Elements are positioned in the normal document flow. 
<div style="position: static;">Static Position</div> 
2. Relative: Positioned relative to its normal position. 
<div style="position: relative; top: 20px; left: 10px;">Relative 
Position</div> 
Explanation: Moves the element 20px down and 10px to the right relative to its 
normal position. 
3. Absolute: Positioned relative to the nearest positioned ancestor. 
<div style="position: relative;"> 
<div style="position: absolute; top: 10px; left: 10px;">Absolute 
Position</div> 
</div> 
4. Fixed: Positioned relative to the viewport and does not move when the page is 
scrolled. 
<div style="position: fixed; top: 0; left: 0;">Fixed Position</div> 
Display 
1. Block: Takes up the full width available, creating a new line. 
<div style="display: block;">Block Element</div> 
2. Inline: Takes up only as much width as necessary and does not create a new line. 
<span style="display: inline;">Inline Element</span> 
3. Inline-block: Similar to inline but allows setting width and height. 
<div style="display: inline-block; width: 100px; height: 
50px;">Inline-block Element</div> 
4. None: Hides the element. 
<div style="display: none;">This element is hidden.</div> 
3. Styling with Classes and IDs 
Selectors and Specificity 
1. Classes (.): Used to style multiple elements. 
<div class="box">Box 1</div> 
<div class="box">Box 2</div> 
<style> 
.box { 
border: 1px solid black; 
padding: 10px; 
} 
</style> 
2. IDs (#): Used to style a single, unique element. 
<div id="unique-box">Unique Box</div> 
<style> 
#unique-box { 
background-color: yellow; 
} 
</style> 
Pseudo-classes 
Pseudo-classes define the special state of an element, such as when a user hovers over it or 
focuses on it. 
1. :hover: Applies styles when the mouse is over an element. 
<button style="background-color: blue; color: white;"  
onmouseover="this.style.backgroundColor='green'"  
onmouseout="this.style.backgroundColor='blue'">Hover 
Me</button> 
2. :focus: Applies styles when an element is focused. 
<input type="text" style="border: 2px solid black;"  
onfocus="this.style.border='2px solid red';"  
onblur="this.style.border='2px solid black';"  
placeholder="Focus Me"> 
4. Layout Design 
Flexbox 
Flexbox is used to create 1D layouts, aligning items in rows or columns. 
Example: 
<div style="display: flex; justify-content: space-between;"> 
<div>Item 1</div> 
<div>Item 2</div> 
<div>Item 3</div> 
</div> 
Properties: 
• justify-content: Aligns items horizontally (e.g., center, space-between). 
• align-items: Aligns items vertically (e.g., center, stretch). 
CSS Grid 
CSS Grid is used for 2D layouts, managing rows and columns. 
Example: 
<div style="display: grid; grid-template-columns: 1fr 1fr; grid-gap: 
10px;"> 
<div>Box 1</div> 
<div>Box 2</div> 
<div>Box 3</div> 
<div>Box 4</div> 
</div> 
Properties: 
• grid-template-columns: Defines the number and size of columns. 
• grid-gap: Adds spacing between grid items. 
Media Queries 
Media queries enable responsive design by applying styles based on device size. 
Example: 
<style> 
body { 
font-size: 16px; 
} 
@media (max-width: 600px) { 
body { 
font-size: 14px; 
} 
} 
</style> 
Explanation: 
• The styles inside the @media block apply when the screen width is 600px or smaller. 
JavaScript Basics and Introduction to ES6 Features 
JavaScript is a versatile programming language that powers the dynamic behavior of web 
applications. It allows developers to create interactive and engaging web experiences. ES6 
(ECMAScript 2015) introduced significant updates to JavaScript, making the language more 
modern, concise, and powerful. 
1. JavaScript Basics 
What is JavaScript? 
JavaScript is a scripting language used to make web pages interactive. It can manipulate 
HTML and CSS, control multimedia, and update content dynamically without requiring a 
page reload. 
How to Include JavaScript in HTML 
JavaScript can be added to an HTML file in several ways: 
1. Inline: Adding JavaScript directly inside an HTML element's attribute. 
<button onclick="alert('Hello!')">Click Me</button> 
2. Internal Script: Using a <script> tag inside the HTML document. 
<script> 
console.log("Hello from JavaScript!"); 
</script> 
3. External File: Linking an external JavaScript file using the <script> tag. 
<script src="app.js"></script> 
2. Overview of ES6 Features 
ES6 introduced several features to improve code readability, conciseness, and 
maintainability. Below are the key features covered in this section. 
Arrow Functions 
Arrow functions provide a shorter syntax for writing functions. They are especially useful for 
callbacks and functional programming. 
Traditional Function Syntax: 
function add(a, b) { 
return a + b; 
} 
console.log(add(2, 3)); // Output: 5 
Arrow Function Syntax: 
const add = (a, b) => a + b; 
console.log(add(2, 3)); // Output: 5 
Key Points: 
• If the function body contains a single return statement, curly braces {} and the return 
keyword can be omitted. 
• Arrow functions do not bind their own this context, making them suitable for use in 
callbacks. 
Example with Array Methods: 
const numbers = [1, 2, 3, 4, 5]; 
const squares = numbers.map(num => num * num); 
console.log(squares); // Output: [1, 4, 9, 16, 25] 
Template Literals 
Template literals allow embedding variables and expressions directly within strings using 
backticks (`) and ${} placeholders. 
Traditional String Concatenation: 
const name = "Alice"; 
const greeting = "Hello, " + name + "!"; 
console.log(greeting); // Output: Hello, Alice! 
Template Literal Syntax: 
const name = "Alice"; 
const greeting = `Hello, ${name}!`; 
console.log(greeting); // Output: Hello, Alice! 
Features: 
1. Multiline Strings: 
const multiline = `This is line 1. 
This is line 2.`; 
console.log(multiline); 
2. Expression Interpolation: 
const a = 5; 
const b = 10; 
console.log(`The sum of ${a} and ${b} is ${a + b}.`); 
// Output: The sum of 5 and 10 is 15. 
Destructuring 
Destructuring allows extracting values from arrays or objects and assigning them to variables 
in a concise way. 
Array Destructuring: 
const numbers = [1, 2, 3]; 
const [first, second, third] = numbers; 
console.log(first, second, third); // Output: 1 2 3 
Object Destructuring: 
const user = { name: "Alice", age: 25, city: "New York" }; 
const { name, age, city } = user; 
console.log(name, age, city); // Output: Alice 25 New York 
Default Values: 
const user = { name: "Alice" }; 
const { name, age = 30 } = user; 
console.log(name, age); // Output: Alice 30 
Nested Destructuring: 
const user = { name: "Alice", address: { city: "New York", zip: "10001" } 
}; 
const { address: { city, zip } } = user; 
console.log(city, zip); // Output: New York 10001 
Modules 
Modules allow code to be divided into smaller, reusable files, making it easier to maintain 
and organize. 
Exporting from a Module: In math.js: 
export const add = (a, b) => a + b; 
export const subtract = (a, b) => a - b; 
Importing into Another File: In app.js: 
import { add, subtract } from './math.js'; 
console.log(add(5, 3));      
// Output: 8 
console.log(subtract(5, 3)); // Output: 2 
Default Exports: A file can have a default export, which simplifies importing: In math.js: 
export default function multiply(a, b) { 
return a * b; 
} 
In app.js: 
import multiply from './math.js'; 
console.log(multiply(4, 5)); // Output: 20 
Dynamic Imports: Modules can also be imported dynamically for lazy loading: 
import('./math.js').then(math => { 
console.log(math.add(2, 3)); // Output: 5 
}); 
DOM Manipulation and Event Handling in JavaScript 
The Document Object Model (DOM) is a programming interface for HTML and XML 
documents. It represents the page structure as a tree of objects, allowing JavaScript to interact 
with and modify the content, structure, and style of web pages dynamically. 
2. DOM Manipulation 
DOM Manipulation involves accessing, modifying, and updating elements in the HTML 
structure using JavaScript. 
Accessing Elements 
1. getElementById 
o Used to select an element by its id attribute. 
o Returns a single HTMLElement object. 
Example: 
<div id="greeting">Hello, World!</div> 
<script> 
const element = document.getElementById("greeting"); 
console.log(element.textContent); // Output: Hello, World! 
</script> 
2. querySelector 
o Selects the first element that matches a specified CSS selector. 
o Supports a wide range of selectors like class, id, and tag. 
Example: 
<p class="message">First Message</p> 
<p class="message">Second Message</p> 
<script> 
const element = document.querySelector(".message"); 
console.log(element.textContent); // Output: First Message 
</script> 
3. querySelectorAll 
o Selects all elements that match a specified CSS selector. 
o Returns a NodeList, which can be iterated using forEach. 
Example: 
<p class="message">First Message</p> 
<p class="message">Second Message</p> 
<script> 
const elements = document.querySelectorAll(".message"); 
elements.forEach(el => console.log(el.textContent)); 
// Output: 
// First Message 
// Second Message 
</script> 
Modifying Elements 
1. Updating Properties 
o You can change the content of an element using the innerHTML or textContent 
property. 
Example: 
<div id="welcome">Welcome!</div> 
<script> 
const element = document.getElementById("welcome"); 
element.innerHTML = "<strong>Welcome to our site!</strong>"; 
// Changes content to bold text 
</script> 
2. Changing Attributes 
o Attributes like src, href, class, or custom attributes can be modified using 
setAttribute or directly accessing the property. 
Example: 
<img id="logo" src="old_logo.png" alt="Logo"> 
<script> 
const image = document.getElementById("logo"); 
image.setAttribute("src", "new_logo.png"); 
image.alt = "Updated Logo"; 
</script> 
3. Styling Elements 
o The style property can be used to modify inline styles. 
Example: 
<div id="box" style="width: 100px; height: 100px; background-color: 
red;"></div> 
<script> 
const box = document.getElementById("box"); 
box.style.backgroundColor = "blue"; // Changes background color 
to blue 
</script> 
3. Event Handling 
Event handling allows JavaScript to respond to user interactions like clicks, form 
submissions, or keyboard input. 
Adding Event Listeners 
1. addEventListener 
o Attaches an event listener to an element for a specific event type. 
Example: 
<button id="myButton">Click Me</button> 
<script> 
const button = document.getElementById("myButton"); 
button.addEventListener("click", () => { 
alert("Button clicked!"); 
}); 
</script> 
2. Inline Event Handlers (Not recommended) 
o You can directly add JavaScript code to an element's attribute, but this approach is 
less modular and harder to maintain. 
Example: 
<button onclick="alert('Button clicked!')">Click Me</button> 
Managing User Interactions 
1. Form Submission 
o Use the submit event to handle form submissions. 
Example: 
<form id="myForm"> 
<input type="text" name="username" required> 
<button type="submit">Submit</button> 
</form> 
<script> 
const form = document.getElementById("myForm"); 
form.addEventListener("submit", event => { 
event.preventDefault(); // Prevents page reload 
alert("Form submitted!"); 
}); 
</script> 
2. Button Click 
o Handle click events for buttons to perform actions. 
Example: 
<button id="greetButton">Greet</button> 
<div id="message"></div> 
<script> 
const button = document.getElementById("greetButton"); 
button.addEventListener("click", () => { 
const message = document.getElementById("message"); 
message.textContent = "Hello, User!"; 
}); 
</script> 
3. Keyboard Events 
o Use keydown or keyup to capture user input. 
Example: 
<input type="text" id="inputBox" placeholder="Type something..."> 
<p id="output"></p> 
<script> 
const inputBox = document.getElementById("inputBox"); 
inputBox.addEventListener("keydown", event => { 
const output = document.getElementById("output"); 
output.textContent = `You pressed: ${event.key}`; 
}); 
</script> 
Best Practices for DOM Manipulation and Event Handling 
1. Use addEventListener Over Inline Handlers 
o It keeps your code modular and separates JavaScript from HTML. 
2. Optimize DOM Access 
o Access elements once and store them in variables to avoid repeated lookups. 
3. Event Delegation 
o Attach a single event listener to a parent element to handle events on multiple child 
elements efficiently. 
Example: 
<ul id="list"> 
<li>Item 1</li> 
<li>Item 2</li> 
<li>Item 3</li> 
</ul> 
<script> 
const list = document.getElementById("list"); 
list.addEventListener("click", event => { 
if (event.target.tagName === "LI") { 
alert(`You clicked on ${event.target.textContent}`); 
} 
}); 
</script>
