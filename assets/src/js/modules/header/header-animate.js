import {animate} from "motion";
import {$} from "../utils/dom";

export function initHeaderAnimate() {
    const header = $("header");
    if (!header) return;

    animate(header, {opacity: [0, 1], y: [-6, 0]}, {duration: 0.25});
}
