import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-code-form',
  templateUrl: './code-form.component.html',
  styleUrls: ['./code-form.component.css']
})
export class CodeFormComponent implements OnInit {

  code:string;

  constructor(private http: HttpClient) { }

  ngOnInit() {
    
  }

  sendCode(code: HTMLInputElement) : boolean {
    const body = {"text": code.value};

    console.log(`Sending body...`);
    console.log(body);
    this.http.post("http://localhost:8080/api/submitCode",body).subscribe(data => {
      console.log("Attempted to send...");
      console.log("Response....");
      console.log(data)
    });

    return false;

  }

}
