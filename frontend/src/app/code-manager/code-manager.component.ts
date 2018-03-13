import {
  Component,
  OnInit,
  EventEmitter,
  Output
} from '@angular/core';
import { HttpClient } from '@angular/common/http';

import swal from 'sweetalert2';

import { Statistics } from '../statistics.model';
import { CodeFile } from '../code-file.model';

@Component({
  selector: 'app-code-manager',
  templateUrl: './code-manager.component.html',
  styleUrls: ['./code-manager.component.css']
})
export class CodeManagerComponent implements OnInit {

  @Output() onStatsReceived: EventEmitter<Statistics>;

  codeFiles: CodeFile[];

  selectedCodeFile: CodeFile;

  constructor(private http: HttpClient) {
    this.onStatsReceived = new EventEmitter<Statistics>();

    this.codeFiles = [];
    this.codeFiles.push(new CodeFile('one.java', 'one'));
    this.codeFiles.push(new CodeFile('two.java', 'two'));
    this.codeFiles.push(new CodeFile('three.java', 'three'));

    this.selectedCodeFile = this.codeFiles[0];
  }

  ngOnInit() { }

  changeFile(newFile: CodeFile): boolean {
    this.selectedCodeFile = newFile;
    return false;
  }

  sendCode(code: HTMLInputElement): boolean {

    if (!code) {
      swal('Empty Code', 'You must enter some text to be scanned', 'error');
      return false;
    }


    const body = {'text': code};
    console.log(body);
    this.http.post<Statistics>('http://localhost:8080/api/submitCode', body).subscribe(data => {
      console.log(data);


      const obj = {
        title: 'Submitting...',
        timer: 2000,
        onOpen: () => {
          swal.showLoading();
        }
      };

      swal(obj).then((result) => {
        if(data.valid) {
          this.onStatsReceived.emit(data);
        } else {
          swal('Invalid Code', 'Not recognised as valid Java code', 'error');
        }
        
      });

      return false;

    });
  }
}
