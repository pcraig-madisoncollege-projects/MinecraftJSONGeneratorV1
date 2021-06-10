// Define global tellraw JSON values for list selections
var colors = ["white", "black", "dark_blue", "dark_green", "dark_aqua", "dark_red",
        "dark_purple", "gold", "gray", "dark_gray", "blue", "green", "aqua",
        "red", "light_purple", "yellow", "reset"];
var booleanValues = [false, true];
var targetSelectors = ["@a", "@p", "@e", "@s"];
var keybindIdentifiers = ["key.jump", "key.sneak", "key.sprint", "key.left",
        "key.right", "key.back", "key.forward", "key.attack", "key.pickItem",
        "key.use", "key.drop", "key.hotbar.1", "key.hotbar.2", "key.hotbar.3",
        "key.hotbar.4", "key.hotbar.5", "key.hotbar.6", "key.hotbar.7",
        "key.hotbar.8", "key.hotbar.9", "key.inventory", "key.swapHands",
        "key.loadToolbarActivator", "key.saveToolbarActivator", "key.playerlist",
        "key.chat", "key.command", "key.advancements", "key.spectatorOutlines",
        "key.screenshot", "key.smoothCamera", "key.fullscreen", "key.togglePerspective"];

/*
    This function is the constructor for a tellraw text element.
*/
function TextElement(id) {
    this.id = id;
    this.fullID = "element" + id;
    this.text = "";
    this.color = "white";
    this.colorIndex = colors.indexOf(this.color);
    this.bold = false;
    this.boldIndex = booleanValues.indexOf(this.bold);
    this.underline = false;
    this.underlineIndex = booleanValues.indexOf(this.underline);
    this.strikethrough = false;
    this.strikethroughIndex = booleanValues.indexOf(this.strikethrough);
    this.obfuscate = false;
    this.obfuscateIndex = booleanValues.indexOf(this.obfuscate);
}

/*
    This function gets a tellraw text element instance's unique id.
*/
TextElement.prototype.getID = function() {
    return this.id;
}

/*
    This function retrieves form inputs from the page and stores them into
    the tellraw element instance.
*/
TextElement.prototype.refreshProperties = function() {
    var textInput = document.getElementById(this.fullID + "text");
    var colorInput = document.getElementById(this.fullID + "color");
    var boldInput = document.getElementById(this.fullID + "bold");
    var underlineInput = document.getElementById(this.fullID + "underline");
    var strikethroughInput = document.getElementById(this.fullID + "strikethrough");
    var obfuscateInput = document.getElementById(this.fullID + "obfuscate");
    
    // Retrieve field values from the tellraw form for this instance
    if (textInput != null) {
        this.text = textInput.value.replace(/"/g, '\\"');
    }
    if (colorInput != null) {
        this.color = colorInput.value;
        this.colorIndex = colors.indexOf(this.color);
    }
    if (boldInput != null) {
        this.bold = (boldInput.value === 'true');
        this.boldIndex = booleanValues.indexOf(this.bold);
    }
    if (underlineInput != null) {
        this.underline = (underlineInput.value === 'true');
        this.underlineIndex = booleanValues.indexOf(this.underline);
    }
    if (strikethroughInput != null) {
        this.strikethrough = (strikethroughInput.value === 'true');
        this.strikethroughIndex = booleanValues.indexOf(this.strikethrough);
    }
    if (obfuscateInput != null) {
        this.obfuscate = (obfuscateInput.value === 'true');
        this.obfuscateIndex = booleanValues.indexOf(this.obfuscate);
    }
}

/*
    This function generates an HTML list item containing this instance's
    field values.
*/
TextElement.prototype.generateListItemHTML = function() {
    this.refreshProperties();
    
    // Generate form inputs from current field values of the tellraw element
    var listItem = '<li>';
    listItem += '<label for="' + this.fullID + 'text">Text: </label>';
    listItem += '<input class="form-control" id="' + this.fullID + 'text" type="text" value="' + this.text + '">';
    
    listItem += generateTextFormattingInputs(this.fullID, this.colorIndex, 
            this.boldIndex, this.underlineIndex, this.strikethroughIndex,
            this.obfuscateIndex);
    
    listItem += ' ' + generateRemoveButton(this.id);
    
    listItem += '</li>';
    
    
    return listItem;
}

/*
    This function generates the JSON used by Minecraft for this type of
    tellraw element.
*/
TextElement.prototype.generateJSON = function() {
    this.refreshProperties();
    
    var jsonElement = '{"text":"' + this.text + '"';
    
    // Generate color value if it is not the default color
    if (this.colorIndex !== 0) {
        jsonElement += ',"color":"' + this.color + '"';
    }
    
    // Generate text formatting if required, otherwise optimize JSON element
    if (this.bold) {
        jsonElement += ',"bold":"true"';
    }
    
    if (this.underline) {
        jsonElement += ',"underline":"true"';
    }
    
    if (this.strikethrough) {
        jsonElement += ',"strikethrough":"true"';
    }
    
    if (this.obfuscate) {
        jsonElement += ',"obfuscated":"true"';
    }
    
    jsonElement += '}';
    
    return jsonElement;
}


/*
    This function is the constructor for a tellraw linebreak element.
*/
function LineBreakElement(id) {
    this.id = id;
    this.fullID = "element" + id;
    this.text = "\\n";
}

/*
    This function gets a tellraw linebreak element instance's unique id.
*/
LineBreakElement.prototype.getID = function() {
    return this.id;
}

/*
    This function generates an HTML list item containing this instance's
    field values.
*/
LineBreakElement.prototype.generateListItemHTML = function() {
    var listItem = '<li>'
    
    // Generate form inputs from current field values of the tellraw element
    listItem += '<div class="form-group">Line Break (\\n)</div>';
    
    listItem += ' ' + generateRemoveButton(this.id);
    
    listItem += '</li>';
    
    
    return listItem;
}

/*
    This function generates the JSON used by Minecraft for this type of
    tellraw element.
*/
LineBreakElement.prototype.generateJSON = function() {
    var jsonElement = '{"text":"' + this.text + '"}';
    
    return jsonElement;
}


/*
    This function is the constructor for a tellraw selector element.
*/
function SelectorElement(id) {
    this.id = id;
    this.fullID = "element" + id;
    this.targetSelector = "@a";
    this.targetSelectorIndex = targetSelectors.indexOf(this.targetSelector);
    this.arguments = "";
    this.color = "white";
    this.colorIndex = colors.indexOf(this.color);
    this.bold = false;
    this.boldIndex = booleanValues.indexOf(this.bold);
    this.underline = false;
    this.underlineIndex = booleanValues.indexOf(this.underline);
    this.strikethrough = false;
    this.strikethroughIndex = booleanValues.indexOf(this.strikethrough);
    this.obfuscate = false;
    this.obfuscateIndex = booleanValues.indexOf(this.obfuscate);
}

/*
    This function gets a tellraw selector element instance's unique id.
*/
SelectorElement.prototype.getID = function() {
    return this.id;
}

/*
    This function retrieves form inputs from the page and stores them into
    the tellraw element instance.
*/
SelectorElement.prototype.refreshProperties = function() {
    var targetSelectorInput = document.getElementById(this.fullID + "target");
    var argumentsInput = document.getElementById(this.fullID + "arguments");
    var colorInput = document.getElementById(this.fullID + "color");
    var boldInput = document.getElementById(this.fullID + "bold");
    var underlineInput = document.getElementById(this.fullID + "underline");
    var strikethroughInput = document.getElementById(this.fullID + "strikethrough");
    var obfuscateInput = document.getElementById(this.fullID + "obfuscate");
    
    // Retrieve field values from the tellraw form for this instance
    if (targetSelectorInput != null) {
        this.targetSelector = targetSelectorInput.value;
        this.targetSelectorIndex = targetSelectors.indexOf(this.targetSelector);
    }
    if (argumentsInput != null) {
        this.arguments = argumentsInput.value;
    }
    if (colorInput != null) {
        this.color = colorInput.value;
        this.colorIndex = colors.indexOf(this.color);
    }
    if (boldInput != null) {
        this.bold = (boldInput.value === 'true');
        this.boldIndex = booleanValues.indexOf(this.bold);
    }
    if (underlineInput != null) {
        this.underline = (underlineInput.value === 'true');
        this.underlineIndex = booleanValues.indexOf(this.underline);
    }
    if (strikethroughInput != null) {
        this.strikethrough = (strikethroughInput.value === 'true');
        this.strikethroughIndex = booleanValues.indexOf(this.strikethrough);
    }
    if (obfuscateInput != null) {
        this.obfuscate = (obfuscateInput.value === 'true');
        this.obfuscateIndex = booleanValues.indexOf(this.obfuscate);
    }
}

/*
    This function generates an HTML list item containing this instance's
    field values.
*/
SelectorElement.prototype.generateListItemHTML = function() {
    this.refreshProperties();
    
    // Generate form inputs from current field values of the tellraw element
    var listItem = '<li><div class="form-group">';
    listItem += '<label for="' + this.fullID + 'target">Target Selector: </label>';
    listItem += generateSelectionInput(this.fullID + 'target', targetSelectors, this.targetSelectorIndex);
    listItem += "</div>";
    
    listItem += '<div class="form-group"><label for="' + this.fullID + 'arguments"> Arguments: </label>';
    listItem += '<input class="form-control" id="' + this.fullID + 'arguments" type="text" value="' + this.arguments + '"></div>';
    
    listItem += generateTextFormattingInputs(this.fullID, this.colorIndex, 
            this.boldIndex, this.underlineIndex, this.strikethroughIndex,
            this.obfuscateIndex);
    
    listItem += ' ' + generateRemoveButton(this.id);
    
    listItem += '</li>';
    
    
    return listItem;
}

/*
    This function generates the JSON used by Minecraft for this type of
    tellraw element.
*/
SelectorElement.prototype.generateJSON = function() {
    this.refreshProperties();
    
    var jsonElement = '{"selector":"' + this.targetSelector
            + this.arguments + '"';
    
    // Generate color value if it is not the default color
    if (this.colorIndex !== 0) {
        jsonElement += ',"color":"' + this.color + '"';
    }
    
    // Generate text formatting if required, otherwise optimize JSON element
    if (this.bold) {
        jsonElement += ',"bold":"true"';
    }
    
    if (this.underline) {
        jsonElement += ',"underline":"true"';
    }
    
    if (this.strikethrough) {
        jsonElement += ',"strikethrough":"true"';
    }
    
    if (this.obfuscate) {
        jsonElement += ',"obfuscated":"true"';
    }
    
    jsonElement += '}';
    
    return jsonElement;
}


/*
    This function is the constructor for a tellraw scoreboard objective element.
*/
function ScoreElement(id) {
    this.id = id;
    this.fullID = "element" + id;
    this.targetSelector = "@a";
    this.targetSelectorIndex = targetSelectors.indexOf(this.targetSelector);
    this.arguments = "";
    this.objective = "objective";
    this.color = "white";
    this.colorIndex = colors.indexOf(this.color);
    this.bold = false;
    this.boldIndex = booleanValues.indexOf(this.bold);
    this.underline = false;
    this.underlineIndex = booleanValues.indexOf(this.underline);
    this.strikethrough = false;
    this.strikethroughIndex = booleanValues.indexOf(this.strikethrough);
    this.obfuscate = false;
    this.obfuscateIndex = booleanValues.indexOf(this.obfuscate);
}

/*
    This function gets a tellraw scoreboard objective element instance's unique id.
*/
ScoreElement.prototype.getID = function() {
    return this.id;
}

/*
    This function retrieves form inputs from the page and stores them into
    the tellraw element instance.
*/
ScoreElement.prototype.refreshProperties = function() {
    var targetSelectorInput = document.getElementById(this.fullID + "target");
    var argumentsInput = document.getElementById(this.fullID + "arguments");
    var objectiveInput = document.getElementById(this.fullID + "objective");
    var colorInput = document.getElementById(this.fullID + "color");
    var boldInput = document.getElementById(this.fullID + "bold");
    var underlineInput = document.getElementById(this.fullID + "underline");
    var strikethroughInput = document.getElementById(this.fullID + "strikethrough");
    var obfuscateInput = document.getElementById(this.fullID + "obfuscate");
    
    // Retrieve field values from the tellraw form for this instance
    if (targetSelectorInput != null) {
        this.targetSelector = targetSelectorInput.value;
        this.targetSelectorIndex = targetSelectors.indexOf(this.targetSelector);
    }
    if (argumentsInput != null) {
        this.arguments = argumentsInput.value;
    }
    if (objectiveInput != null) {
        this.objective = objectiveInput.value;
    }
    if (colorInput != null) {
        this.color = colorInput.value;
        this.colorIndex = colors.indexOf(this.color);
    }
    if (boldInput != null) {
        this.bold = (boldInput.value === 'true');
        this.boldIndex = booleanValues.indexOf(this.bold);
    }
    if (underlineInput != null) {
        this.underline = (underlineInput.value === 'true');
        this.underlineIndex = booleanValues.indexOf(this.underline);
    }
    if (strikethroughInput != null) {
        this.strikethrough = (strikethroughInput.value === 'true');
        this.strikethroughIndex = booleanValues.indexOf(this.strikethrough);
    }
    if (obfuscateInput != null) {
        this.obfuscate = (obfuscateInput.value === 'true');
        this.obfuscateIndex = booleanValues.indexOf(this.obfuscate);
    }
}

/*
    This function generates an HTML list item containing this instance's
    field values.
*/
ScoreElement.prototype.generateListItemHTML = function() {
    this.refreshProperties();
    
    // Generate form inputs from current field values of the tellraw element
    var listItem = '<li><div class="form-group">';
    listItem += '<label for="' + this.fullID + 'target">Target Selector: </label>';
    listItem += generateSelectionInput(this.fullID + 'target', targetSelectors, this.targetSelectorIndex);
    listItem += "</div>";
    
    listItem += '<div class="form-group">';
    listItem += '<label for="' + this.fullID + 'arguments"> Arguments: </label>';
    listItem += '<input class="form-control" id="' + this.fullID + 'arguments" type="text" value="'
            + this.arguments + '">';
    listItem += "</div>";
    
    listItem += '<div class="form-group">';
    listItem += '<label for="' + this.fullID + 'objective"> Scoreboard Objective: </label>';
    listItem += '<input class="form-control" id="' + this.fullID + 'objective" type="text" value="'
            + this.objective + '">';
    listItem += '</div>';
    
    listItem += generateTextFormattingInputs(this.fullID, this.colorIndex, 
            this.boldIndex, this.underlineIndex, this.strikethroughIndex,
            this.obfuscateIndex);
    
    listItem += ' ' + generateRemoveButton(this.id);
    
    listItem += '</li>';
    
    
    return listItem;
}

/*
    This function generates the JSON used by Minecraft for this type of
    tellraw element.
*/
ScoreElement.prototype.generateJSON = function() {
    this.refreshProperties();
    
    var jsonElement = '{"score":{"name":"' + this.targetSelector
            + this.arguments + '","objective":"' + this.objective
            + '"}';
    
    // Generate color value if it is not the default color
    if (this.colorIndex !== 0) {
        jsonElement += ',"color":"' + this.color + '"';
    }
    
    // Generate text formatting if required, otherwise optimize JSON element
    if (this.bold) {
        jsonElement += ',"bold":"true"';
    }
    
    if (this.underline) {
        jsonElement += ',"underline":"true"';
    }
    
    if (this.strikethrough) {
        jsonElement += ',"strikethrough":"true"';
    }
    
    if (this.obfuscate) {
        jsonElement += ',"obfuscated":"true"';
    }
    
    jsonElement += '}';
    
    return jsonElement;
}



/*
    This function is the constructor for a tellraw scoreboard objective element.
*/
function KeybindElement(id) {
    this.id = id;
    this.fullID = "element" + id;
    this.keybind = "key.jump";
    this.keybindIndex = targetSelectors.indexOf(this.keybind);
    this.color = "white";
    this.colorIndex = colors.indexOf(this.color);
    this.bold = false;
    this.boldIndex = booleanValues.indexOf(this.bold);
    this.underline = false;
    this.underlineIndex = booleanValues.indexOf(this.underline);
    this.strikethrough = false;
    this.strikethroughIndex = booleanValues.indexOf(this.strikethrough);
    this.obfuscate = false;
    this.obfuscateIndex = booleanValues.indexOf(this.obfuscate);
}

/*
    This function gets a tellraw keybind element instance's unique id.
*/
KeybindElement.prototype.getID = function() {
    return this.id;
}

/*
    This function retrieves form inputs from the page and stores them into
    the tellraw element instance.
*/
KeybindElement.prototype.refreshProperties = function() {
    var keybindInput = document.getElementById(this.fullID + "key");
    var colorInput = document.getElementById(this.fullID + "color");
    var boldInput = document.getElementById(this.fullID + "bold");
    var underlineInput = document.getElementById(this.fullID + "underline");
    var strikethroughInput = document.getElementById(this.fullID + "strikethrough");
    var obfuscateInput = document.getElementById(this.fullID + "obfuscate");
    
    // Retrieve field values from the tellraw form for this instance
    if (keybindInput != null) {
        this.keybind = keybindInput.value;
        this.keybindIndex = keybindIdentifiers.indexOf(this.keybind);
    }
    if (colorInput != null) {
        this.color = colorInput.value;
        this.colorIndex = colors.indexOf(this.color);
    }
    if (boldInput != null) {
        this.bold = (boldInput.value === 'true');
        this.boldIndex = booleanValues.indexOf(this.bold);
    }
    if (underlineInput != null) {
        this.underline = (underlineInput.value === 'true');
        this.underlineIndex = booleanValues.indexOf(this.underline);
    }
    if (strikethroughInput != null) {
        this.strikethrough = (strikethroughInput.value === 'true');
        this.strikethroughIndex = booleanValues.indexOf(this.strikethrough);
    }
    if (obfuscateInput != null) {
        this.obfuscate = (obfuscateInput.value === 'true');
        this.obfuscateIndex = booleanValues.indexOf(this.obfuscate);
    }
}

/*
    This function generates an HTML list item containing this instance's
    field values.
*/
KeybindElement.prototype.generateListItemHTML = function() {
    this.refreshProperties();
    
    // Generate form inputs from current field values of the tellraw element
    var listItem = '<li>';
    listItem += '<div class="form-group">';
    listItem += '<label for="' + this.fullID + 'key">Keybind: </label>';
    listItem += generateSelectionInput(this.fullID + 'key', keybindIdentifiers, this.keybindIndex);
    listItem += '</div>';
    
    listItem += generateTextFormattingInputs(this.fullID, this.colorIndex, 
            this.boldIndex, this.underlineIndex, this.strikethroughIndex,
            this.obfuscateIndex);
    
    listItem += ' ' + generateRemoveButton(this.id);
    
    listItem += '</li>';
    
    
    return listItem;
}

/*
    This function generates the JSON used by Minecraft for this type of
    tellraw element.
*/
KeybindElement.prototype.generateJSON = function() {
    this.refreshProperties();
    
    var jsonElement = '{"keybind":"' + this.keybind + '"';
    
    // Generate color value if it is not the default color
    if (this.colorIndex !== 0) {
        jsonElement += ',"color":"' + this.color + '"';
    }
    
    // Generate text formatting if required, otherwise optimize JSON element
    if (this.bold) {
        jsonElement += ',"bold":"true"';
    }
    
    if (this.underline) {
        jsonElement += ',"underline":"true"';
    }
    
    if (this.strikethrough) {
        jsonElement += ',"strikethrough":"true"';
    }
    
    if (this.obfuscate) {
        jsonElement += ',"obfuscated":"true"';
    }
    
    jsonElement += '}';
    
    return jsonElement;
}



/*
    This function is the constructor for a tellraw translation element.
*/
function TranslateElement(id) {
    this.id = id;
    this.fullID = "element" + id;
    this.translate = "";
    this.color = "white";
    this.colorIndex = colors.indexOf(this.color);
    this.bold = false;
    this.boldIndex = booleanValues.indexOf(this.bold);
    this.underline = false;
    this.underlineIndex = booleanValues.indexOf(this.underline);
    this.strikethrough = false;
    this.strikethroughIndex = booleanValues.indexOf(this.strikethrough);
    this.obfuscate = false;
    this.obfuscateIndex = booleanValues.indexOf(this.obfuscate);
}

/*
    This function gets a tellraw translation element instance's unique id.
*/
TranslateElement.prototype.getID = function() {
    return this.id;
}

/*
    This function retrieves form inputs from the page and stores them into
    the tellraw element instance.
*/
TranslateElement.prototype.refreshProperties = function() {
    var translateInput = document.getElementById(this.fullID + "translate");
    var colorInput = document.getElementById(this.fullID + "color");
    var boldInput = document.getElementById(this.fullID + "bold");
    var underlineInput = document.getElementById(this.fullID + "underline");
    var strikethroughInput = document.getElementById(this.fullID + "strikethrough");
    var obfuscateInput = document.getElementById(this.fullID + "obfuscate");
    
    // Retrieve field values from the tellraw form for this instance
    if (translateInput != null) {
        this.translate = translateInput.value;
    }
    if (colorInput != null) {
        this.color = colorInput.value;
        this.colorIndex = colors.indexOf(this.color);
    }
    if (boldInput != null) {
        this.bold = (boldInput.value === 'true');
        this.boldIndex = booleanValues.indexOf(this.bold);
    }
    if (underlineInput != null) {
        this.underline = (underlineInput.value === 'true');
        this.underlineIndex = booleanValues.indexOf(this.underline);
    }
    if (strikethroughInput != null) {
        this.strikethrough = (strikethroughInput.value === 'true');
        this.strikethroughIndex = booleanValues.indexOf(this.strikethrough);
    }
    if (obfuscateInput != null) {
        this.obfuscate = (obfuscateInput.value === 'true');
        this.obfuscateIndex = booleanValues.indexOf(this.obfuscate);
    }
}

/*
    This function generates an HTML list item containing this instance's
    field values.
*/
TranslateElement.prototype.generateListItemHTML = function() {
    this.refreshProperties();
    
    // Generate form inputs from current field values of the tellraw element
    var listItem = '<li>';
    listItem += '<div class="form-group">';
    listItem += '<label for="' + this.fullID + 'translate">Translate Identifier: </label>';
    listItem += '<input class="form-control" id="' + this.fullID + 'translate" type="text" value="'
            + this.translate + '">';
    listItem += '</div>';
    
    listItem += generateTextFormattingInputs(this.fullID, this.colorIndex, 
            this.boldIndex, this.underlineIndex, this.strikethroughIndex,
            this.obfuscateIndex);
    
    listItem += ' ' + generateRemoveButton(this.id);
    
    listItem += '</li>';
    
    
    return listItem;
}

/*
    This function generates the JSON used by Minecraft for this type of
    tellraw element.
*/
TranslateElement.prototype.generateJSON = function() {
    this.refreshProperties();
    
    var jsonElement = '{"translate":"' + this.translate + '"';
    
    // Generate color value if it is not the default color
    if (this.colorIndex !== 0) {
        jsonElement += ',"color":"' + this.color + '"';
    }
    
    // Generate text formatting if required, otherwise optimize JSON element
    if (this.bold) {
        jsonElement += ',"bold":"true"';
    }
    
    if (this.underline) {
        jsonElement += ',"underline":"true"';
    }
    
    if (this.strikethrough) {
        jsonElement += ',"strikethrough":"true"';
    }
    
    if (this.obfuscate) {
        jsonElement += ',"obfuscated":"true"';
    }
    
    jsonElement += '}';
    
    return jsonElement;
}