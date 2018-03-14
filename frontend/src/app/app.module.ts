import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';

import { AppComponent } from './app.component';
import { CodeManagerComponent } from './code-manager/code-manager.component';
import { CodeResultsComponent } from './code-results/code-results.component';
import { CodeFileTabComponent } from './code-manager/code-file-tab/code-file-tab.component';
import { CodeFormComponent } from './code-manager/code-form/code-form.component';


@NgModule({
  declarations: [
    AppComponent,
    CodeFormComponent,
    CodeResultsComponent,
    CodeFileTabComponent,
    CodeManagerComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
