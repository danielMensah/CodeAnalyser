import { Class } from './class.model';


export class Statistics {
    constructor() { 
        this.valid = true;
        this.class = new Class();
    }

    valid: boolean;
    response: string;

    class: Class;

}

