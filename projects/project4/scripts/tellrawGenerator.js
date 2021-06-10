// Define list of tellraw elements and unique tellraw element identifier
var elements = [];
var uniqueElementID = 0;

/*
    This function adds a new tellraw element to the array of elements and 
    displays the new entry inputs for that element.
*/
function addElement(type) {
    // Clean entered type
    type = type.trim().toLowerCase();
    
    var newElement;
    
    // Create new tellraw element from the type specified
    switch (type) {
        case "text":
            newElement = new TextElement(uniqueElementID);
            break;
        case "linebreak":
            newElement = new LineBreakElement(uniqueElementID);
            break;
        case "selector":
            newElement = new SelectorElement(uniqueElementID);
            break;
        case "score":
            newElement = new ScoreElement(uniqueElementID);
            break;
        case "keybind":
            newElement = new KeybindElement(uniqueElementID);
            break;
        case "translate":
            newElement = new TranslateElement(uniqueElementID);
            break;
        default:
            return false;
    }
    
    // Add new tellraw element and increment unique id counter
    elements.push(newElement);
    uniqueElementID++;
    
    displayTellrawElements();
    
    return true;
}

/*
    This function removes a specified element from the array of elements.
*/
function removeElement(id) {
    for (var index = 0; index < elements.length; index++) {
        var element = elements[index];
        
        // Remove the element if a match has been found
        if (element.getID() === id) {
            elements.splice(index, 1);
            
            displayTellrawElements();
            
            return true;
        }
    }
    
    return false;
}

/*
    This function generates an unordered list for the HTML page containing
    tellraw elements.
*/
function displayTellrawElements() {
    var outputObject = document.getElementById("tellrawElements");
    
    // Display tellraw elements or message if no elements exist
    if (elements.length > 0) {
        var list = "<ul>";
        
        // Display each tellraw element's form input values
        for (var index = 0; index < elements.length; index++) {
            var element = elements[index];
            
            list += element.generateListItemHTML();
        }
    
        list += "</ul>";
        
        outputObject.innerHTML = list;
    } else {
        outputObject.innerHTML = "<p>No tellraw elements have been added.</p>";
    }
}

/*
    Generates and displays the tellraw command that can then be copied and
    executed in Minecraft.
*/
function generateCommand() {
    var targetSelector;
    var arguments;
    var jsonComponent = '[""';
    var command;
    
    // Retrieve JSON elements from stored tellraw elements
    for (var index = 0; index < elements.length; index++) {
        var element = elements[index];
        
        jsonComponent += ',' + element.generateJSON();
    }
    
    jsonComponent += ']';
    
    // Retrieve target selector and arguments for base tellraw command
    var targetElement = document.getElementById("targetSelector");
    var argumentsElement = document.getElementById("arguments");
    
    targetSelector = targetElement.value;
    arguments = argumentsElement.value;
    
    command = "/tellraw " + targetSelector + arguments + " " + jsonComponent;
    
    // Display command in text area output on page
    var textAreaElement = document.getElementById("commandOutput");
    
    textAreaElement.innerHTML = command;
}

/*
    This function generates an HTML selection form input from an array
    with an index which specifies the selected option.
*/
function generateSelectionInput(htmlID, options, selectedOptionIndex) {
    var selectInputHTML = '<select class="form-control"'
            + ' id="' + htmlID + '">';
    
    // Generate option values as specified by the array of options passed in
    for (var index = 0; index < options.length; index++) {
        
        var optionName = options[index].toString().replace(/_/g, ' ');
        
        // Select an option if it matches the default selected index
        if (selectedOptionIndex === index) {
            selectInputHTML += '<option value="' + options[index] + '" selected>'
                    + optionName + '</option>';
        } else {
            selectInputHTML += '<option value="' + options[index] + '">'
                    + optionName + '</option>';
        }
    }
    
    selectInputHTML += '</select>';
    
    return selectInputHTML;
}

/*
    Generates the HTML code for a remove element button
*/
function generateRemoveButton(id) {
    var output;
    
    // Generates a remove element input as HTML
    output = '<input class="btn btn-primary" type="button" value="Delete Element" '
            + 'onclick="removeElement(' + id + ');">';
    
    return output;
}

/*
    Generates the HTML code for text formatting input for tellraw elements.
*/
function generateTextFormattingInputs(fullID, colorIndex, boldIndex,
        underlineIndex, strikethroughIndex, obfuscateIndex) {
    var output;
    
    // Generates the text formatting values available for many of the tellraw elements
    output = '<label for="' + fullID + 'color"> Color: </label>';
    output += generateSelectionInput(fullID + 'color', colors, colorIndex);
    
    output += '<label for="' + fullID + 'bold"> Bold: </label>';
    output += generateSelectionInput(fullID + 'bold', booleanValues, boldIndex);
    
    output += '<label for="' + fullID + 'underline"> Underline: </label>';
    output += generateSelectionInput(fullID + 'underline', booleanValues, underlineIndex);
    
    output += '<label for="' + fullID + 'strikethrough"> Strikethrough: </label>';
    output += generateSelectionInput(fullID + 'strikethrough', booleanValues, strikethroughIndex);
    
    output += '<label for="' + fullID + 'obfuscate"> Obfuscate: </label>';
    output += generateSelectionInput(fullID + 'obfuscate', booleanValues, obfuscateIndex);
    
    return output;
}