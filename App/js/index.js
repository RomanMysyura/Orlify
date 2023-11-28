import $ from "jquery";

import hola from "./scripts.js";
import handlePasswordValidation from "./password.js";

import displayFileName from "./dropfile.js";
import { initDropFile } from "./dropfile.js";
import { openModal } from "./openmodalalumnes.js";

import { closeModal } from "./openmodalalumnes.js";
import { searchAlumne } from "./openmodalalumnes.js";

openModal();
initDropFile();
handlePasswordValidation();
displayFileName();
closeModal();
searchAlumne();
