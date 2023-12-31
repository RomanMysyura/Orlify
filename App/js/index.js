import $ from "jquery";

import handlePasswordValidation from "./password.js";

import displayFileName from "./dropfile.js";
import { initDropFile } from "./dropfile.js";
import { openModal } from "./openmodalalumnes.js";

import { closeModal } from "./openmodalalumnes.js";
import { searchAlumne } from "./openmodalalumnes.js";
import setCookie from "./cookie.js";
import {getCookie} from "./cookie.js";
import {initializeCookieBanner} from "./cookie.js";
import {moverSlider} from "./slider.js";
import {toggleCamera} from "./camara.js";
import {setupMouseEvents} from "./mousevent.js";

openModal();
initDropFile();
handlePasswordValidation();
displayFileName();
closeModal();
searchAlumne();
setCookie();
getCookie();
initializeCookieBanner();
moverSlider();
toggleCamera();
setupMouseEvents();
