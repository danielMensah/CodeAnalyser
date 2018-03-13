import { Comment } from './comment.model';
import { Function } from './function.model';

export class Class {
    constructor() { 
        this.name = "";
        this.type="";
        
        this.comments = [new Comment()];
        this.functions = [new Function()];
    }

    name: string;
    type: string;

    NLoc: number;

    comments: Comment[];
    functions: Function[];

}

