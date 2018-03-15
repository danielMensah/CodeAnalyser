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

  sendCode(values: {code, rating}): boolean {

    if (!values.code) {
      swal('Empty Code', 'You must enter some text to be scanned', 'error');
      return false;
    }

    var url = "http://localhost:8080/api/submitCode";

    switch(values.rating) {
      case "Select Comment Analysis Tool": {
        console.log("No rating system selected");
        break;
      }
      case "Flesch Kincaid Reading Ease": {
        url += "?readabilityType=fleschKincaidReadingEase";
        break;
      }
      case "Flesch Kincaid Grade Level": {
        url += "?readabilityType=fleschKincaidGradeLevel";
        break;
      }
      case "Gunning Fog Score": {
        url += "?readabilityType=gunningFogIndex";
        break;
      }
      case "Coleman Liau Index": {
        url += "?readabilityType=colemanLiauIndex";
        break;
      }
      case "SMOG Index" : {
        url += "?readabilityType=smogIndex";
        break;
      }
      case "Automated Reability Index" : {
        url += "?readabilityType=automatedReadabilityIndex";
        break;
      }
    }

    console.log(url);

    const body = {'text': values.code};

    console.log(body);
    this.http.post<Statistics>(url, body).subscribe(data => {
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
