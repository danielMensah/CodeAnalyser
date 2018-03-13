export class Comment {

    type: string;
    line: any;
    feedback: string;
    
    constructor() { 
        this.type = "???";
        this.line = "???";
        this.feedback="???";
    }

    getlines(): void {
        console.log("HELLLLLLO");   
    }
}