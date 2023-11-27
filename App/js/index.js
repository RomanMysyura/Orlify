import $ from "jquery";

import hola from "./scripts.js";
import handlePasswordValidation from "./password.js";

import {Example, obj} from "./example.ts";
handlePasswordValidation();
$(function() {
    console.log('Hello World');
    hola();
    console.log("Example", obj);
});

