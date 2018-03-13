import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CodeFileTabComponent } from './code-file-tab.component';

describe('CodeFileTabComponent', () => {
  let component: CodeFileTabComponent;
  let fixture: ComponentFixture<CodeFileTabComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CodeFileTabComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CodeFileTabComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
