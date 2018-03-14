export class Comment {

    type: string;
    line: any;
    feedback: string;
    readabilityScore: number;
    
    constructor() { 
        this.type = "???";
        this.line = "???";
        this.feedback = "???";
        this.readabilityScore = 0;
    }

    getlines(): void {
        console.log("HELLLLLLO");   
    }
}