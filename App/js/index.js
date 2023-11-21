import $ from "jquery";

import hola from "./scripts.js";

import {Example, obj} from "./example.ts";

$(function() {
    console.log('Hello World');
    hola();
    console.log("Example", obj);
});

